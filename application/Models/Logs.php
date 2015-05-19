<?php

namespace application\Models;

use application\Entities\LogEntry;
use Trident\MVC\AbstractModel;

class Logs extends AbstractModel
{

    /**
     * Save log entry to the database.
     *
     * @param LogEntry $log Log entry.
     *
     * @return \Trident\Database\Result
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
     * @return Users
     * @throws \Trident\Exceptions\EntityNotFoundException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function getAll()
    {
        /** @var LogEntry[] $logs */
        $logs = $this->getORM()->find('LogEntry');
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