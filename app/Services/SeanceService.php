<?php

namespace App\Services;

use App\Models\Seance;

class SeanceService
{
    public function create(array $data): Seance
    {
        return Seance::create($data);
    }

    public function update(Seance $seance, array $data): Seance
    {
        $seance->update($data);
        return $seance;
    }

    public function delete(Seance $seance): void
    {
        $seance->delete();
    }
}
