<?php

namespace App\Http\Traits\Actions;

/**
 * Trait ModelActionBase
 * @package App\Http\Traits\Actions
 */
trait ActionBase
{
    protected $actionRecord;

    /** @var array */
    protected $data = [];

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function execute(array $data = [])
    {
        // Set global model
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
            throw $exception;
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
