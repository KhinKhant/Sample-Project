<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PositionRepositoryInterfaces;
use App\Position;
//use Your Model

/**
 * Class EmployeeRepository.
 */
class PositionRepository implements PositionRepositoryInterfaces
{
    /**
     * @return string
     *  Return the model
     */
    public function savePosition($request)
    {
        $position = new Position();
        $position->position_name = $request['position_name'];
        $position->position_rank= $request['position_rank'];
        try
        {
            $position->save();
            return true;

        }catch(Exception $e)
        {
            return false;
        }

    }
}