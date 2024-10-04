<?php

if (!function_exists('formatDuration')) {
    
    function formatDuration($duration)
    {
        $interval = new DateInterval($duration);
        
        $hours = $interval->h;
        $minutes = $interval->i;

        $durationString = '';

        if ($hours > 0) {
            $durationString .= $hours . ' ' . ($hours === 1 ? 'hr' : 'hrs');
        }

        if ($minutes > 0) {
            if ($hours > 0) {
                $durationString .= '  ';
            }
            $durationString .= $minutes . ' ' . ($minutes === 1 ? 'min' : 'mins');
        }

        return $durationString;
    }
}
