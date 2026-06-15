<?php
// app/Services/AIAgentService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Food;
use App\Models\Category;
use App\Models\AiConversation;

class AIAgentService {
    private string $apiKey;
    private string $model;

    public function __construct() {
    $this->apiKey = config('services.openrouter.api_key');
    $this->model  = config('services.openrouter.model', 'mistralai/mistral-7b-instruct');
}

    public function chat(array $messages, ?int $userId = null, string $sessionId = ''): array {
        $menuContext  = $this->getMenuContext();
        $systemPrompt = $this->buildSystemPrompt($menuContext);

        try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
            'HTTP-Referer'  => config('app.url'),
            'X-Title'       => config('app.name'),
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model'      => $this->model,
            'max_tokens' => 1024,
            'messages'   => array_merge(
                [['role' => 'system', 'content' => $systemPrompt]],
                $messages
            ),
        ]);
        // ⬆️ YAHAN TAK REPLACE KARO

            if ($response->successful()) {
                $data    = $response->json();
                $aiReply = $data['choices'][0]['message']['content'] ?? 'Sorry, I could not process your request.';

                $parsed = $this->parseAIResponse($aiReply);

                if ($sessionId) {
                    AiConversation::updateOrCreate(
                        ['session_id' => $sessionId],
                        [
                            'user_id'         => $userId,
                            'messages'        => $messages,
                            'detected_mood'   => $parsed['mood']     ?? null,
                            'detected_emoji'  => $parsed['emoji']    ?? null,
                            'suggested_foods' => $parsed['food_ids'] ?? null,
                        ]
                    );
                }

                return [
                    'success'         => true,
                    'message'         => $aiReply,
                    'mood'            => $parsed['mood']  ?? null,
                    'emoji'           => $parsed['emoji'] ?? null,
                    'suggested_foods' => $this->getSuggestedFoods($parsed['food_ids'] ?? []),
                ];
            }

            $errorBody = $response->json();
            $errorMsg  = $errorBody['error']['message'] ?? 'AI service temporarily unavailable.';
            return ['success' => false, 'message' => $errorMsg];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection error: ' . $e->getMessage()];
        }
    }

    private function buildSystemPrompt(string $menuContext): string {
        return <<<PROMPT
You are Zara 🍽️, the friendly AI assistant for FoodieHub Restaurant!

Your personality:
- Warm, enthusiastic, and food-loving
- You understand Pakistani culture and food preferences
- You detect the customer's mood from their message or emoji
- You give personalized food recommendations based on mood
- You can also answer general questions like a helpful assistant

You can help with:
1. 🍽️ Food recommendations based on mood
2. 💬 General conversation and questions
3. 📋 Menu information and prices
4. 🕐 Restaurant timings, location queries
5. 🌍 General knowledge questions
6. 🧾 Order suggestions and combos

Mood Detection Guide:
😊😄🎉 Happy/Celebratory → Suggest festive dishes, platters, desserts
😢😭😔 Sad/Down → Suggest comfort foods: biryani, karahi, chocolate desserts
😡🤬 Angry/Stressed → Suggest spicy foods like wings, karahi, BBQ to release tension
😴💤 Tired/Lazy → Suggest easy, filling comfort meals
🥳🎂 Celebrating → Suggest special platters, cakes, premium dishes
❤️💕 Romantic/Date → Suggest elegant dishes, pastas, desserts for two
🏃‍♂️💪 After workout → Suggest high-protein: grilled chicken, seekh kebab, prawns
🤒🤧 Sick → Suggest light soups, rice dishes, warm beverages
☕🌅 Morning/Breakfast → Suggest breakfast items: English breakfast, lassi
🍕🍔 Craving something specific → Match to closest menu item

IMPORTANT:
- Always respond in the same language the user writes in (Urdu/Roman Urdu or English).
- If question is NOT food related, answer it helpfully like a general assistant, then gently bring conversation back to food.
- If question IS food related, follow the food recommendation format below.

Menu Context:
{$menuContext}

For food-related responses, include:
1. Detect mood from message/emoji
2. Warm personal greeting acknowledging their mood
3. 2-3 specific food recommendations from the menu with prices in PKR
4. Why these foods match their current mood/need
5. Ask a follow-up question to refine recommendation

For MOOD_DATA parsing (only include when food mood is detected):
MOOD_DATA:mood=MOOD_HERE|emoji=EMOJI|food_ids=ID1,ID2,ID3

Example:
"MOOD_DATA:mood=happy|emoji=😊|food_ids=1,8,19"
PROMPT;
    }

    private function getMenuContext(): string {
        $foods = Food::with('category')
            ->where('is_available', true)
            ->select('id', 'name', 'price', 'cuisine', 'spicy_level', 'category_id', 'description')
            ->get();

        $context    = "Available Menu Items:\n";
        $byCategory = $foods->groupBy('category.name');
        foreach ($byCategory as $cat => $items) {
            $context .= "\n{$cat}:\n";
            foreach ($items as $item) {
                $context .= "- [{$item->id}] {$item->name} - Rs.{$item->price} ({$item->cuisine}, {$item->spicy_level} spicy)\n";
            }
        }
        return $context;
    }

    private function parseAIResponse(string $response): array {
        $result = [];
        if (preg_match('/MOOD_DATA:mood=([^|]+)\|emoji=([^|]+)\|food_ids=([^\n]+)/', $response, $matches)) {
            $result['mood']     = trim($matches[1]);
            $result['emoji']    = trim($matches[2]);
            $result['food_ids'] = array_map('intval', explode(',', trim($matches[3])));
        }
        return $result;
    }

    private function getSuggestedFoods(array $ids): array {
        if (empty($ids)) return [];
        return Food::whereIn('id', $ids)
            ->where('is_available', true)
            ->select('id', 'name', 'price', 'discount_price', 'image', 'rating', 'cuisine', 'spicy_level')
            ->get()
            ->map(fn($f) => [
                'id'              => $f->id,
                'name'            => $f->name,
                'price'           => $f->price,
                'effective_price' => $f->effective_price,
                'image'           => $f->image_url,
                'rating'          => $f->rating,
                'cuisine'         => $f->cuisine,
                'spicy_icon'      => $f->spicy_icon,
            ])
            ->toArray();
    }

    public function getGreeting(): array {
        $hour = now()->hour;
        if ($hour < 12) {
            return ['emoji' => '🌅', 'greeting' => "Good morning! Ready for breakfast?",   'mood_prompt' => "😊😴🍳"];
        } elseif ($hour < 17) {
            return ['emoji' => '☀️', 'greeting' => "Good afternoon! What's on your mind?", 'mood_prompt' => "😊😋🍜"];
        } else {
            return ['emoji' => '🌙', 'greeting' => "Good evening! Time for dinner?",        'mood_prompt' => "😊😌🍽️"];
        }
    }
}