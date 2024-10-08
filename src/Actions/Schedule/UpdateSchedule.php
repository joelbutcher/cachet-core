<?php

namespace Cachet\Actions\Schedule;

use Cachet\Models\Schedule;

class UpdateSchedule
{
    /**
     * Handle the action.
     */
    public function handle(Schedule $schedule, array $data = [], ?array $components = []): Schedule
    {
        $schedule->update($data);

        if ($components) {
            $components = collect($components)->map(fn ($component) => [
                'component_id' => $component['id'],
                'component_status' => $component['status'],
            ])->all();

            $schedule->components()->sync($components);
        }

        // @todo Dispatch notification that maintenance was updated.

        return $schedule->fresh();
    }
}
