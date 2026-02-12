<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class ResourceCollectionProvicder extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $crudResponses = [
            'success' => ['message' => 'OK', 'status' => Response::HTTP_OK],
            'created' => ['message' => 'Resource created', 'status' => Response::HTTP_CREATED],
            'updated' => ['message' => 'Resource updated', 'status' => Response::HTTP_OK],
            'deleted' => ['message' => 'Resource deleted', 'status' => Response::HTTP_OK],
            'error'   => ['message' => 'An error occurred', 'status' => Response::HTTP_BAD_REQUEST],
        ];

        foreach ($crudResponses as $type => $config) {
            ResourceCollection::macro("with" . ucfirst($type), function (?string $message = null) use ($type, $config) {
                return $this->additional([
                    'success' => $type !== 'error',
                    'message' => $message ?? $config['message'],
                ])->response()->setStatusCode($config['status']);
            });
        }
    }
}
