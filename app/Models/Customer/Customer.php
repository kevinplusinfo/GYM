<?php
namespace App\Models\Customer;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'profile_image'];


    protected $hidden = [
        'password', 'remember_token',
    ];
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id', 'id');
    }
    public function fcmTokens()
    {
        return $this->hasMany(FcmToken::class);
    }
    
    public function selectedPlans()
    {
        return $this->hasMany(SelectedPlan::class);
    }

}
