<?php
// 代码生成时间: 2025-09-13 20:47:31
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 数据模型设计示例
 *
 * 包含用户(User)和帖子(Post)两个数据模型
 */

// 用户模型
class User extends Model
{
    use HasFactory;

    // 定义用户模型的属性
    protected $fillable = ['name', 'email', 'password'];

    // 用户和帖子的多对多关联
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}

// 帖子模型
class Post extends Model
{
    use HasFactory;

    // 定义帖子模型的属性
    protected $fillable = ['title', 'content', 'user_id'];

    // 帖子和用户的多对多关联
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

// 帖子标签模型
class PostTag extends Model
{
    use HasFactory;

    // 定义帖子标签模型的属性
    protected $fillable = ['post_id', 'tag_id'];

    // 帖子和标签的多对多关联
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}

// 标签模型
class Tag extends Model
{
    use HasFactory;

    // 定义标签模型的属性
    protected $fillable = ['name'];

    // 标签和帖子的多对多关联
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }
}

// 数据库迁移文件
// 2023_01_01_000000_create_users_table.php
class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

// 2023_01_02_000000_create_posts_table.php
class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

// 2023_01_03_000000_create_post_tags_table.php
class CreatePostTagsTable extends Migration
{
    public function up()
    {
        Schema::create('post_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained();
            $table->foreignId('tag_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_tags');
    }
}

// 2023_01_04_000000_create_tags_table.php
class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
