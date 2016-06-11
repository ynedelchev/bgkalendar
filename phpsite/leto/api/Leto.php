<?php

/**
 * This is the interface each Leto (Calendar) has to define. 
 */
interface Leto { 

    
    /**
     * @return LetoPeriodType[]
     */
    public function getCalendarPeriodTypes();
    
    /**
     * Calculate the periods based on the number of days since the leto (calendar) EPOCH.
     * @param days Number of days since the calendar starts. (long)
     * @return The calculated array of periods. (LetoPeriod[])
     * @throws LetoException If there is some unrecoverable error while calculating the date.
     */
    public function calculateCalendarPeriods($days);
}
?>
