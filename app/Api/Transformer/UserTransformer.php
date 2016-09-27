<?php namespace App\Api\Transformer;


use App\User;
use League\Fractal\Manager;
use Tymon\JWTAuth\Token;

class UserTransformer extends BaseTransformer {

	protected $defaultIncludes = ['photo'];

	protected $availableIncludes = ['token', 'googleOAuth'];

	/**
	 * @var null
	 */
	private $token;

	/**
	 * UserTransformer constructor.
	 * @param null $token
	 */
	public function __construct($token = null)
	{
		parent::__construct();
		if (isset($_GET['include']))
		{
			$manager = new Manager();
			$manager->parseIncludes($_GET['include']);
		}
		$this->token = $token;
	}

	public function transform(User $user)
	{
		return [
			'name' => $user->name,
			'username' => $user->username,
			'email' => $user->email,
			'bio' => $user->bio,
			'createdAt' => $user->created_at
		];
	}

	public function includePhoto(User $user)
	{
		$photo = $this->photoRepository->userAvatar($user);
		return $this->item($photo, new SimplePhotoTransformer());
	}

	public function includeToken()
	{
		return $this->item(new Token($this->token), new TokenTransformer());
	}

	public function includeGoogleOAuth()
	{
		return $this->item(null, new GoogleOAuthTransformer());
	}

}