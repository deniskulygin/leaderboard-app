<?php
declare(strict_types = 1);

namespace LeaderBoard\Documentation\Services;

use Illuminate\Config\Repository;
use Illuminate\Routing\UrlGenerator;

/**
 * Class AssetHandler
 *
 * @package Documentation\Services
 */
class AssetHandler
{

    private $urlGenerator;

    public function __construct(private readonly Repository $config)
    {
    }

    public function getConfig(): Repository
    {
        return $this->config;
    }

    /**
     * @return UrlGenerator
     * @throws \LogicException Url generator must be set before using.
     */
    public function getUrlGenerator(): UrlGenerator
    {
        if ($this->urlGenerator === null) {
            throw new \LogicException('Url generator must be set before using');
        }

        return $this->urlGenerator;
    }

    public function setUrlGenerator(UrlGenerator $urlGenerator): AssetHandler
    {
        $this->urlGenerator = $urlGenerator;

        return $this;
    }

    /**
     * @param string $asset
     *
     * @return string
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function createAssetLink(string $asset): string
    {
        return $this->getUrlGenerator()->route('documentation.asset', [$asset]);
    }

    /**
     * @param string[] $assets
     *
     * @return string[]
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function createAssetsLinks(array $assets): array
    {
        $links = [];
        foreach ($assets as $key => $asset) {
            $links[$key] = $this->createAssetLink($asset);
        }

        return $links;
    }

    public function getAssetFilePath(string $asset): string
    {
        $file = $this->getConfig()->get('swagger.paths.assets') . DIRECTORY_SEPARATOR . $asset;

        return $file;
    }

    /**
     * @param string $asset
     *
     * @return string
     * @throws \LogicException Asset file is not found $asset.
     * @throws \LogicException Something has gone wrong during fetching asset content $asset.
     */
    public function fetchAssetContent(string $asset): string
    {
        $file = $this->getAssetFilePath($asset);
        if (!file_exists($file)) {
            throw new \LogicException(
                'Asset file is not found [' . $asset . ']'
            );
        }

        $content = file_get_contents($file);
        if ($content === false) {
            throw new \LogicException('Something went wrong while reading the asset [' . $asset . ']');
        }

        return $content;
    }
}
