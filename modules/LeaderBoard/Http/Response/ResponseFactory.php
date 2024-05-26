<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Response;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class ResponseFactory
{
    public function __construct(private readonly Manager $manager)
    {
    }

    public function item(Model $item, TransformerAbstract $transformer): Response
    {
        $item = new Item($item, $transformer);
        $responseData = $this->manager->createData($item)->toArray();

        return new Response($responseData, 200);
    }

    public function collection(
        LengthAwarePaginator $paginator,
        TransformerAbstract $transformer
    ): Response
    {
        $fractalPaginator = new IlluminatePaginatorAdapter($paginator);
        $items = (new Collection($paginator->getCollection(), $transformer))->setPaginator($fractalPaginator);
        $responseData = $this->manager->createData($items)->toArray();

        return new Response($responseData, 200);
    }
}
