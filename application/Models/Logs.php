<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Models;

use Application\Entities\LogEntry;
use Trident\MVC\AbstractModel;
use Trident\Database\Result;
use Trident\Exceptions\EntityNotFoundException;
use Trident\Exceptions\ModelNotFoundException;

/**
 * Class Logs
 *
 * This class provides the data-access layer to the logs in the database.
 *
 * @package Application\Models
 */
class Logs extends AbstractModel
{

    /**
     * Save log entry to the database.
     *
     * @param LogEntry $log Log entry.
     *
     * @return Result
     */
    public function saveLogEntry($log)
    {
        if (!$log instanceof LogEntry)
        {
            throw new \InvalidArgumentException("Save log entry argument must be a valid LogEntry entity");
        }
        return $this->getORM()->save($log);
    }

    /**
     * Get all log entries.
     *
     * @return LogEntry[]
     *
     * @throws EntityNotFoundException
     * @throws ModelNotFoundException
     */
    public function getAll()
    {
        /** @var LogEntry[] $logs */
        $logs = $this->getORM()->find('LogEntry', '1', [], 'log_id DESC');
        /** @var Users $users */
        $users = $this->loadModel('Users');
        foreach ($logs as $key => $log)
        {
            if ($log->user !== null)
            {
                $logs[$key]->user = $users->getById($log->user);
            }
        }
        return $logs;
    }
} 