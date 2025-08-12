<?php
// 代码生成时间: 2025-08-12 23:34:32
namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Notifications\MessageNotification;

class NotificationSystem {

    /**
     * Send a notification to a user.
     *
     * @param User $user The user to send the notification to.
     * @param string $message The message to send.
     * @return bool
     */
    public function sendNotification(User $user, string $message): bool {
        try {
            // Check if the user has notification enabled
            if (!$user->notification_enabled) {
                Log::warning('Notification failed: User has disabled notifications.');
                return false;
            }

            // Send the notification
            return $user->notify(new MessageNotification($message));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Notification failed: ' . $e->getMessage());
            return false;
        }
    }
}

/**
 * A notification class for message notifications.
 *
 * This class is used to define the data structure for message notifications.
 */
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

class MessageNotification extends Notification {
    /**
     * The message content.
     *
     * @var string
     */
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param string $message
     */
    public function __construct(string $message) {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
        // Define the channels used for sending notifications
        return ['nexmo'];
    }

    /**
     * Get the nexmo / SMS representation of the notification.
     *
     * @param mixed $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable) {
        return (new NexmoMessage)
            ->content($this->message);
    }
}

/**
 * User model with notification enabled attribute.
 *
 * This model represents a user and includes an attribute for notification preference.
 */
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'notification_enabled',
    ];

    /**
     * Indicates if the user has notification enabled.
     *
     * @var bool
     */
    public $notification_enabled;
}
