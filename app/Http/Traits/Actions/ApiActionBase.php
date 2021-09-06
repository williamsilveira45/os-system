<?php

namespace App\Http\Traits\Actions;

trait ApiActionBase
{
    use ApiResponseMessage;

    /** @var array */
    protected $data = [];

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function execute(array $data = [])
    {
        return $this->init($data);
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    protected function init(array $data = [])
    {
        try {
            // Set parameters
            if (!empty($data) || isset($this->setParameters)) {
                $this->setParameters($data);
            }

            // Execute main functions
            return $this->main();
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * Set the parameters used throughout the class from the data passed to it
     * Override this to change how the parameters are set and add validation
     *
     * @param array $data
     */
    abstract protected function setParameters(array $data): void;

    /**
     * Main function - add the main logic for the class here
     */
    abstract protected function main();
}
