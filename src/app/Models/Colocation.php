<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = [
        'name',
        'max_members',
        'status',
        'country',
        'city',
        'desc',
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
