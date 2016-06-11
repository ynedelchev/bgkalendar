package bg.util.leto.api;



/**
 * This is the interface each Leto (Calendar) has to define. 
 */
public interface Leto { 

    
    LetoPeriodType[] getCalendarPeriodTypes();
    
    /**
     * Calculate the periods based on the number of days since the leto (calendar) EPOCH.
     * @param days Number of days since the calendar starts.
     * @return The calculated array of periods.
     * @throws LetoException If there is some unrecoverable error while calculating the date.
     */
    public LetoPeriod[] calculateCalendarPeriods(long days) throws LetoException;
}
