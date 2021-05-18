<?php
class MoveVideo extends PluginAbstract
{
  /**
   * @var string Name of plugin
   */
  public $name = 'MoveVideo';

  /**
   * @var string Description of plugin
   */
  public $description = 'Change video ownership, moving assets as needed.';

  /**
   * @var string Name of plugin author
   */
  public $author = 'Justin Henry';

  /**
   * @var string URL to plugin's website
   */
  public $url = 'https://uvm.edu/~jhenry/';

  /**
   * @var string Current version of plugin
   */
  public $version = '0.0.3';


  /**
   * Performs install operations for plugin. Called when user clicks install
   * plugin in admin panel.
   *
   */
  public function install()
  {
  }
  /**
   * Performs uninstall operations for plugin. Called when user clicks
   * uninstall plugin in admin panel and prior to files being removed.
   *
   */
  public function uninstall()
  {
  }

  /**
   * The plugin's gateway into codebase. Place plugin hook attachments here.
   */
  public function load()
  {
    define('MOVEVIDEO_LOG', dirname(__FILE__) . '/move-video.log');
    Plugin::attachFilter ( 'router.static_routes' , array( __CLASS__ , 'addRoutes' ) );
  }

  
  /**
   * Allow admin access only
   */
  public function verifyAccess()
  {
    // Verify if user is logged in
    $authService = new AuthService();
    //$authService->enforceAuth();
    //$authService->enforceTimeout(true);

    $userService = new UserService();
    if(!$userService->checkPermissions("admin_panel")) {
      exit();
      //App::throw404();
    }
  }

  /**
   * Add route for migration form 
   * 
   */
  public static function addRoutes($routes)
  {
    $routes['move-video'] = new Route(array(
          'path' => 'move-video',
          'location' => DOC_ROOT . '/cc-content/plugins/MoveVideo/form.php',
          'name' => 'move-video'
          ));
    return $routes;
  }

  /**
   * get a list of a user's videos to move
   * 
   */
  public function getVideoList()
  {

    $userMapper = new UserMapper();
    if(isset($_GET['user-search'])) {
      $sourceUser = $userMapper->getUserByUsername($_GET['user-search']);
    }
    else {
      $authService = new AuthService();
      $sourceUser = $authService->getAuthUser();
    }

    if($sourceUser) {
      $videoMapper = new VideoMapper();
      $videos = $videoMapper->getUserVideos($loggedInUser->userId);
    }
    
    return $videos;
  }

  /**
   * Get user homeDirectory
   * 
   * @param User $user user object to get homeDir for
   */
  public function getUserHomeDir($user)
  {
    $userDir = false;   
    if (class_exists('Wowza')) {
      $userDir = Wowza::get_user_homedirectory($user->userId); 
    }
    if (!$userDir) {
      self::log("WARN: Unable to get homeDirectory for $user->username - exiting...");
    }
    return $userDir;
  }

  public function log($message) 
  {
    require_once dirname(__FILE__) . '/analog/lib/Analog.php';

    $analog = new Analog();
    $analog->handler(Analog\Handler\File::init(MOVEVIDEO_LOG));
    $analog::$timezone = "EDT";

    $analog->log ($message);
  }
}
