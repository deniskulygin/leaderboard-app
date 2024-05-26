<?php
declare(strict_types = 1);

namespace LeaderBoard\Documentation\Http\Controllers;

use Illuminate\Routing\Controller;
use LeaderBoard\Documentation\Services\AssetHandler;
use Illuminate\Config\Repository;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;

class DocumentationController extends Controller
{
    public function __construct(private readonly ResponseFactory $responseFactory, private readonly Repository $config)
    {
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function documentation(AssetHandler $assetHandler): Response
    {
        $data = array_merge(
            $assetHandler->createAssetsLinks($this->config->get('swagger.assets')),
            ['swaggerUrl' => '/' . $this->config->get('swagger.paths.build_swagger_file')]
        );

        return $this->responseFactory->view($this->config->get('swagger.view'), $data);
    }

    /**
     * @throws \LogicException
     */
    public function asset(string $asset, AssetHandler $assetHandler): Response
    {
        return $this->responseFactory->make(
            $assetHandler->fetchAssetContent($asset),
            Response::HTTP_OK,
            [
                'Content-Type' => pathinfo($asset)['extension'] === 'css' ? 'text/css' : 'application/javascript',
            ]
        );
    }
}
