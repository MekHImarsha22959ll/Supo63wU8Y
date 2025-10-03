<?php
// 代码生成时间: 2025-10-03 18:20:39
use Faker\Factory;
use Illuminate\Support\Facades\Http;

class MockDataGenerator {
    /**
     * Generate mock data for a given API endpoint.
     *
     * @param string $endpoint API endpoint URL
     * @param int $count Number of mock data records to generate
     * @return array
     * @throws Exception
     */
    public function generateMockData(string $endpoint, int $count): array
    {
        // Initialize the Faker factory
        $faker = Factory::create();

        try {
            // Fetch real data from the API endpoint
            $response = Http::get($endpoint);
            $response->throw();
            $data = $response->json();

            // Generate mock data based on the real data structure
            $mockData = [];
            foreach ($data as $key => $value) {
                $mockData[$key] = $faker->word;
            }

            // Return an array of mock data records
            return array_fill(0, $count, $mockData);

        } catch (\Throwable $e) {
            // Handle any errors that occur during the process
            throw new Exception("Error generating mock data: " . $e->getMessage());
        }
    }
}
