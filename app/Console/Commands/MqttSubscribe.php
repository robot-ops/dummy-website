<?php

namespace App\Console\Commands;

use App\Models\Datalogger;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\Mqtt;
use Illuminate\Support\Facades\Log;

class MqttSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mqtt-subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to MQTT topic and save data to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $topic = env('MQTT_SUBSCRIBE_TOPIC', 'data/Haiwell/percobaan1/+');
        
        $this->info("Subscribing to topic: {$topic}");

        $mqtt = Mqtt::connection('default');

        $mqtt->subscribe($topic, function (string $topic, string $message) {
            $this->info("Received message on topic [{$topic}]: {$message}");
            
            try {
                $data = json_decode($message, true);
                
                if (isset($data['data1']) && isset($data['data2'])) {
                    Datalogger::create([
                        'data1' => $data['data1'],
                        'data2' => $data['data2'],
                        'logged_at' => now(),
                    ]);
                    $this->info("Data saved to database.");
                } else {
                    $this->warn("Invalid data format received.");
                }
            } catch (\Exception $e) {
                Log::error("MQTT Subscribe Error: " . $e->getMessage());
                $this->error("Error processing message: " . $e->getMessage());
            }
        });

        $mqtt->loop(true);
    }
}
