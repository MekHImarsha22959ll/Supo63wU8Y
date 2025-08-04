<?php
// 代码生成时间: 2025-08-04 18:19:11
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Exception;

// WebContentScraper.php

class WebContentScraper {
    private $url;
    private $htmlContent;
    private $crawler;

    // 构造函数，接收要抓取的网页URL
    public function __construct(string $url) {
        $this->url = $url;
    }

    // 获取网页内容
    public function fetch(): string {
        try {
            // 使用Laravel的Http客户端获取网页内容
            $response = Http::get($this->url);
            $response->throw(); // 抛出异常，如果请求失败

            // 存储HTML内容
            $this->htmlContent = $response->body();

            // 返回HTML内容
            return $this->htmlContent;
        } catch (Exception $e) {
            // 错误处理
            return "Error: " . $e->getMessage();
        }
    }

    // 解析网页内容
    public function parse(): array {
        $this->crawler = new Crawler($this->htmlContent);
        // 根据需要解析的内容，这里以获取所有标题为例
        return $this->crawler->filter('h1')->each(function (Crawler $node, $i) {
            return $node->text();
        });
    }

    // 运行抓取程序
    public function run() {
        $html = $this->fetch();
        if ($html !== false) {
            // 解析HTML内容
            $titles = $this->parse();
            print_r($titles);
        } else {
            echo $html; // 输出错误信息
        }
    }
}

// 使用示例
$scraper = new WebContentScraper('https://example.com');
$scraper->run();