<?php
// 代码生成时间: 2025-10-07 02:56:25
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

// 营销活动模型
class MarketingCampaign extends Model
{
    use HasFactory;

    // 营销活动与用户之间的关联
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campaign_user');
    }

    // 存储营销活动
    public function storeCampaign(array $data): bool
    {
        try {
            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'budget' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return false; // 验证失败返回false
            }

            $this->create($data); // 创建营销活动
            return true; // 创建成功返回true
        } catch (\Exception $e) {
            // 错误处理
            Log::error('Campaign creation failed: ' . $e->getMessage());
            return false;
        }
    }
}

// 用户模型
class User extends Model
{
    use HasFactory;

    // 用户与营销活动之间的关联
    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(MarketingCampaign::class, 'campaign_user');
    }
}

// 营销活动管理控制器
class MarketingCampaignController extends Controller
{
    public function index(): View
    {
        $campaigns = MarketingCampaign::all();
        return view('marketing_campaigns.index', compact('campaigns'));
    }

    public function create(): View
    {
        return view('marketing_campaigns.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $campaignData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'budget' => 'required|numeric',
        ]);

        if ($campaign = MarketingCampaign::create($campaignData)) {
            return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully.');
        }

        return back()->withErrors('Failed to create campaign.')->withInput();
    }
}

// 营销活动工厂
class MarketingCampaignFactory extends Factory
{
    protected $model = MarketingCampaign::class;

    public function definition(): array
    {
        return [
            'name' => \$this->faker->word,
            'description' => \$this->faker->text,
            'start_date' => \$this->faker->dateTime,
            'end_date' => \$this->faker->dateTime,
            'budget' => \$this->faker->randomNumber,
        ];    
    }
}

// 路由定义
Route::get('/campaigns', [MarketingCampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/create', [MarketingCampaignController::class, 'create'])->name('campaigns.create');
Route::post('/campaigns', [MarketingCampaignController::class, 'store'])->name('campaigns.store');
