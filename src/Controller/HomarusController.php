<?php
namespace Islandora\Homarus\Controller;

use GuzzleHttp\Psr7\StreamWrapper;
use Islandora\Crayfish\Commons\CmdExecuteService;
use Islandora\Crayfish\Commons\ApixFedoraResourceRetriever;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class HomarusController
 * @package Islandora\Homarus\Controller
 * @param $log
 */
class HomarusController {

  /**
   * @var \Islandora\Crayfish\Commons\CmdExecuteService
   */
  protected $cmd;


  /**
   * @var \Monolog\Logger
   */
  protected $log;

  /**
   * Controller constructor.
   * @param \Islandora\Crayfish\Commons\CmdExecuteService $cmd
   * @param $log
   */
  public function __construct(
    CmdExecuteService $cmd,
    $log
  ) {
    $this->cmd = $cmd;
    $this->log = $log;
  }

  /**
   * @param \Symfony\Component\HttpFoundation\Request $request
   * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\StreamedResponse
   */
  public function convert(Request $request) {
    $this->log->info('Convert request.');
    $fedora_resource = $request->attributes->get('fedora_resource');
    // Get image as a resource.
    $body = StreamWrapper::getResource($fedora_resource->getBody());

    $cmd_string = "ffmpeg -f mp4 -i - -f avi -";

    // Return response.
    try {
      return new StreamedResponse(
        $this->cmd->execute($cmd_string, $body),
        200,
        ['Content-Type' => "video/avi"]
      );
    } catch (\RuntimeException $e) {
      $this->log->error("RuntimeException:", ['exception' => $e]);
      return new Response($e->getMessage(), 500);
    }

  }


  public function sayYo() {
    return "Yo Yo";
  }

}
