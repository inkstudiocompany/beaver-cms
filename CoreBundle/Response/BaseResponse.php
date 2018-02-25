<?php
namespace Beaver\CoreBundle\Response;

use Beaver\CoreBundle\Model\Interfaces\ModelInterface;
use Beaver\CoreBundle\Response\Interfaces\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseResponse implements ResponseInterface
{
	/**
	 * CONSTANTS
	 */
	const SUCCESS   =  true;
	const FAIL      = false;
	
	/**
	 * @var null
	 */
	protected $data = null;
	
	/**
	 * @var bool
	 */
	private $status = self::SUCCESS;
	
	/**
	 * @var string
	 */
	private $error = '';
	
	/**
	 * Retorna el TRUE si la respuesta es válida, FALSE si se generó algún error.
	 * @return bool
	 */
	public function isSuccess()
	{
		return $this->State();
	}
	
	/**
	 * Retorna el TRUE si la respuesta es válida, FALSE si se generó algún error.
	 * @return bool
	 */
	public function State()
	{
		return $this->status;
	}
	
	/**
	 * @param bool $status
	 *
	 * @return $this|mixed
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}
	
	/**
	 * Retorna el error generado.
	 *
	 * @return string
	 */
	public function getError(): string
	{
		return $this->error;
	}
	
	/**
	 * Agrega el error si existe.
	 *
	 * @param string $error
	 *
	 * @return $this|mixed
	 */
	public function setError(string $error)
	{
		$this->error = $error;
		$this->setStatus(self::FAIL);
		return $this;
	}
	
	/**
	 * Agrega los datos a la respuesta.
	 * @param $data
	 * @return $this
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}
	
	/**
	 * Retorna los datos contenidos en la respuesta.
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}
	
	/**
	 *
	 */
	public function reset()
    {
        $this->data     = null;
        $this->error    = '';
        $this->status   = self::SUCCESS;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        if (true === is_null($this->data) || true === empty($this->data)) {
            return true;
        }

        return false;
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        $data = $this->getData();
        if (true === $this->getData() instanceof ModelInterface) {
            $data = $this->getData()->toArray();
        }
        
        return [
            'status'    => $this->isSuccess(),
            'error'     => $this->getError(),
            'data'      => $data
        ];
    }
	
	/**
	 * Returns valid Symfony JsonResponse.
	 *
	 * @return JsonResponse
	 */
	public function toJsonResponse()
	{
		return new JsonResponse($this->toArray());
	}
}
