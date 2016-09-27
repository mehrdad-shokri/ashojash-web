<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CollectionVenuePivot extends Pivot {

	protected $dates = ['starts_at', 'ends_at', 'created_at', 'ends_at'];
}
