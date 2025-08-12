<?php
// 代码生成时间: 2025-08-12 10:10:27
 * It's designed to be easily understandable and maintainable.
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;

class TestDataGenerator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });

        // Generate test data
        $this->generateTestData(100);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_data');
    }

    /**
     * Generate test data using Faker.
     *
     * @param int $count Number of test records to generate.
     * @return void
     */
    protected function generateTestData(int $count)
    {
        $faker = app(Faker::class);

        Model::unguard();

        for ($i = 0; $i < $count; $i++) {
            try {
                DB::table('test_data')->insert([
                    'name' => $faker->name,
                    'email' => $faker->email,
                ]);
            } catch (\Exception $e) {
                // Handle any errors that occur during data generation
                \Log::error('Error generating test data: ' . $e->getMessage());
            }
        }

        Model::reguard();
    }
}
