<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class FavoritePublication extends Model
    {
        protected $table = 'favorite_publication';

        protected $fillable = [
            'user_id',
            'publicacion_id',
        ];

        public function publicacion()
        {
            return $this->belongsTo(Publicacion::class, 'publicacion_id');
        }

        public function user()
        {
            return $this->belongsTo(User::class, 'id');
        }
    }
