<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\DB;

    class Review extends Model
    {
//        status field: 0 => flagged, 1 => approved, -1 => deleted
        use SoftDeletes;
        protected $fillable = ['cost', 'decor', 'quality', 'comment', 'venue_id'];
        protected $dates=['deleted_at','created_at','updated_at'];
        public function venue()
        {
            return $this->belongsTo('App\Venue');

        }

        public function user()
        {
            return $this->belongsTo('App\User');
        }


        public static function C()
        {
            /*$count = Cache::remember('totalSum', 10, function () {
                return DB::table('reviews')->count();
            });
            $decorSum = Cache::remember('totalDecor', 10, function () {
                return DB::table('reviews')->sum('decor');
            });
            $qualitySum = Cache::remember('totalQuality', 10, function () {
                return DB::table('reviews')->sum('quality');
            });*/
            $count = DB::table('reviews')->count();
            $decorSum = DB::table('reviews')->sum('decor');
            $qualitySum = DB::table('reviews')->sum('quality');
            if ($count == 0)
                $count = 1;

//		$decorSum = DB::table('reviews')->sum('decor');
//		$qualitySum = DB::table('reviews')->sum('quality');
            $totalSum = $decorSum + (2 * $qualitySum);
            $average = $totalSum / ($count * 3);
            return round($average, 1);
        }

        public function reviewAve()
        {
            return (2 * ($this->cost) + 2 * ($this->quality) + $this->decor) / 5;
        }
    }
