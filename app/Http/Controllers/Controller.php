<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

 /**
 * @OA\OpenApi (
 *      @OA\Info(
 *          version="1.0.0",
 *          title="Swagger Gerenciamento de Hospedagem",
 *          description="Documentação do Gerenciamento de Hospedagem",
 *          termsOfService="http://swagger.io/terms/",
 *          @OA\Contact(
 *             email="luizcsdev@gmail.com"
 *          ),
 *          @OA\License(
 *              name="MIT",
 *              url="https://opensource.org/licenses/MIT"
 *          )
 *      ),
 * 
 *      @OA\Server(
 *          description="OpenApi host",
 *          url="http://localhost:8000"
 *      ),
 *      @OA\ExternalDocumentation(
 *          description="Find out more about Swagger",
 *          url="http://swagger.io"
 *      )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
