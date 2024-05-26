<?php
declare(strict_types = 1);

namespace LeaderBoard\Documentation\Services;

use Illuminate\Config\Repository;

class SwaggerBuilder
{
    const REF_KEY = '$ref';

    public function __construct(private readonly Repository $config)
    {
    }

    public function getConfig(): Repository
    {
        return $this->config;
    }

    /**
     * @throws \LogicException
     */
    public function buildSwaggerJson(): void
    {
        $file = $this->getConfig()->get('swagger.paths.docs')
            . DIRECTORY_SEPARATOR . $this->getConfig()->get('swagger.paths.docs_json');

        if (!file_exists($file)) {
            throw new \LogicException('The main json swagger file does not exist');
        }

        $swaggerData = $this->resolveJsonRefs(json_decode(file_get_contents($file)));

        file_put_contents(
            $this->getConfig()->get('swagger.paths.build_swagger_path')
                . DIRECTORY_SEPARATOR . $this->getConfig()->get('swagger.paths.build_swagger_file'),
            json_encode($swaggerData, JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * @param array|\stdClass $swaggerData
     * @param string          $relativePath
     *
     * @return array|\stdClass
     * @throws \LogicException
     */
    private function resolveJsonRefs($swaggerData, string $relativePath = '')
    {

        if (is_object($swaggerData)
            && isset($swaggerData->{self::REF_KEY})
            && str_starts_with($swaggerData->{self::REF_KEY}, '#') === false
        ) {
            $refContent = $this->fetchRefFileData($swaggerData->{self::REF_KEY}, $relativePath);
            $swaggerData = (object)array_merge((array)$swaggerData, (array)$refContent);
            $relativePath .=
                DIRECTORY_SEPARATOR
                . substr($swaggerData->{self::REF_KEY}, 0, strrpos($swaggerData->{self::REF_KEY}, '/'));
            unset($swaggerData->{self::REF_KEY});
        }

        foreach ($swaggerData as &$value) {
            if (is_object($value) || is_array($value)) {
                $value = $this->resolveJsonRefs($value, $relativePath);
            }
        }

        return $swaggerData;
    }

    /**
     * @throws \LogicException The file does not exist: $fileName.
     */
    private function fetchRefFileData(string $ref, string $relativePath): \stdClass
    {
        $filename = $this->getConfig()->get('swagger.paths.docs')
            . DIRECTORY_SEPARATOR . $relativePath . DIRECTORY_SEPARATOR . $ref;

        if (!file_exists($filename)) {
            throw new \LogicException('The file does not exist: ' . $filename);
        }

        return json_decode(file_get_contents($filename));
    }
}
