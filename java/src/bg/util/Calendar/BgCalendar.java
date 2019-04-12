package bg.util.Calendar;

import java.util.Calendar;

public class BgCalendar extends Calendar {

	
	
    private BgCalendar() {
    	
    }
	
	
	
	public static Calendar getInstance() {
		return null;
	}
	
	
	
	@Override
	public void add(int arg0, int arg1) {
		// TODO Auto-generated method stub
		
	}

	@Override
	protected void computeFields() {
		// TODO Auto-generated method stub
		
	}

	@Override
	protected void computeTime() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public int getGreatestMinimum(int arg0) {
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public int getLeastMaximum(int arg0) {
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public int getMaximum(int arg0) {
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public int getMinimum(int arg0) {
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public void roll(int arg0, boolean arg1) {
		// TODO Auto-generated method stub
		
	}
	
	
	/**
	 * Serial Version Id declared because the class is serialized.
	 */
	private static final long serialVersionUID = 3229062188032140295L;

	/**
	 * If we start counting from the beginning of the Bulgarian Calendar, how much days have 
	 * to pass till we get to the standard Java EPOCH 1-st of January 1970.
	 */
	protected static long EPOCH_OFFSET_DAYS = 1000; 
	
	/**
	 * This member variable specifies the number of days that have passed since the begining of the 
	 * Bulgarian Calendar till the date that this Calendar instance represents.
	 *  Based on that value we can calculate how much years have passed since the 
	 * beginning of the Bulgarian Calendar till this calendar date. We can also calculate what is the 
	 * what is the exact date this calendar represents in terms of Months, day within the monthe, day witin 
	 * the week and so on. 
	 */
	protected long mDaysSinceBeginningOfCalendar = 0;
	
	public static String[] YEAR_NAMES_EN = new String[] {
		"Somor", 		"Shegor", "Tiger", 
		"Dvansh", 		"Vereni", "Dilom", 	"Teku Imenshegor", 
		"Tekuchitem", 	"Monkey", "Toh", 	"Eth", 
		"Dohs"
	};
	
	public static String[] YEAR_NAMES_BG = new String[] {
	    "Ð¡Ð¾Ð¼Ð¾Ñ€", 		"Ð¨ÐµÐ³Ð¾Ñ€", 	"Ð¢Ð¸Ð³ÑŠÑ€", 
	    "Ð”Ð²Ð°Ð½Ñˆ", 		"Ð’ÐµÑ€ÐµÐ½Ð¸", 	"Ð”Ð¸Ð»Ð¾Ð¼", 	"Ð¢ÐµÐºÑƒ Ð˜Ð¼ÐµÐ½ÑˆÐµÐ³Ð¾Ñ€", 
	    "Ð¢ÐµÐºÑƒÑ‡Ð¸Ñ‚ÐµÐ¼", 	"ÐœÐ°Ð¹Ð¼ÑƒÐ½Ð°", 	"Ð¢Ð¾Ñ…", 		"Ð•Ñ‚Ñ…", 
	    "Ð”Ð¾Ñ…Ñ�"
	};
	
	public static String[] YEAR_ANIMALS_EN = new String[] {
		"Mouse", 	"Ox", 		"Tiger", 
		"Rabbit", 	"Dragon", 	"Snake", 	"Horse", 
		"Ram", 		"Monkey", 	"Hen", 		"Dog", 
		"Pig"	
	};
	
	public static String[] YEAR_ANIMALS_BG = new String[] {
	    "ÐœÐ¸ÑˆÐºÐ°", "Ð’Ð¾Ð»", "Ð¢Ð¸Ð³ÑŠÑ€", "Ð—Ð°ÐµÐº", "Ð”Ñ€Ð°ÐºÐ¾Ð½", "Ð—Ð¼Ð¸Ñ�", 
	    "ÐšÐ¾Ð½", "ÐžÐ²ÐµÐ½", "ÐœÐ°Ð¹Ð¼ÑƒÐ½Ð°", "ÐšÐ¾ÐºÐ¾ÑˆÐºÐ°", "ÐšÑƒÑ‡Ðµ", "Ð¡Ð²Ð¸Ð½Ñ�"
	};   
	
	public static String[] MONTHS_NAMES_EN = new String[] {
	     "Ignazhden",
	     "Alem", 	"Tutom", 	"Chitem", 
	     "Tvirem ", "Vechem", 	"Shehtem",
	     "Behti",
	     "Setem",   "Esem", 	"Devem", 
	     "Elem",	"Elnem", 	"Altom" 

	};
	
	public static String[] MONTHS_NAMES_BG = new String[] {
		"Ð˜Ð³Ð½Ð°Ð¶Ð´ÐµÐ½",
		"Ð�Ð»ÐµÐ¼", 	"Ð¢ÑƒÑ‚Ð¾Ð¼", 	"Ð§Ð¸Ñ‚ÐµÐ¼", 
		"Ð¢Ð²Ð¸Ñ€ÐµÐ¼", 	"Ð’ÐµÑ‡ÐµÐ¼", 	"Ð¨ÐµÑ…Ñ‚ÐµÐ¼",
		"Ð‘ÐµÑ…Ñ‚Ð¸",
		"Ð¡ÐµÑ‚ÐµÐ¼",	"Ð•Ñ�ÐµÐ¼", 	"Ð”ÐµÐ²ÐµÐ¼",
		"Ð•Ð»ÐµÐ¼", 	"Ð•Ð»Ð½ÐµÐ¼", 	"Ð�Ð»Ñ‚Ð¾Ð¼" 
	};
	

	protected static final int[] DAYS_IN_MONTH_NON_LEAP_YEAR = new int[] {
		1, 
		31, 30, 30, 
		31, 30, 30,
		0,
		31, 30, 30, 
		31, 30, 30
	};
	
	protected static final int[] DAYS_IN_MONTH_LEAP_YEAR = new int[] {
		1, 
		31, 30, 30, 
		31, 30, 30,
		1, 
		31, 30, 30,
		31, 30, 30
	};
	
	// --------------------------------------------------------------------------------------
	protected static final int DAYS_IN_LEAP_YEAR = 366;
	
	protected static final int DAYS_IN_NON_LEAP_YEAR = 365;
	
	protected static final int[] P4_YEAR_PERIOD_DAYS_LEAP = new int[] {
		DAYS_IN_NON_LEAP_YEAR, DAYS_IN_NON_LEAP_YEAR, DAYS_IN_NON_LEAP_YEAR, DAYS_IN_LEAP_YEAR  
	};

	protected static final int[] P4_YEAR_PERIOD_DAYS_NON_LEAP = new int[] {
		DAYS_IN_NON_LEAP_YEAR, DAYS_IN_NON_LEAP_YEAR, DAYS_IN_NON_LEAP_YEAR, DAYS_IN_NON_LEAP_YEAR
	};
	
	protected static final boolean[] P4_YEAR_PERIOD_ISLEAP_LEAP = new boolean[] {
		false, false, false, true
	};
	
	protected static final boolean[] P4_YEAR_PERIOD_IS_LEAP_NON_LEAP = new boolean[] {
		false, false, false, false
	};

	// --------------------------------------------------------------------------------------
	
	protected static final int DAYS_IN_LEAP_P4_YEAR_PERIOD = 1461;
	protected static final int DAYS_IN_NON_LEAP_P4_YEAR_PERIOD = 1460;
	
	protected static final int[] P60_YEAR_PERIOD_DAYS_LEAP = new int[] {
		DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
		DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
		DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
		DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
		DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
		DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
		DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
		DAYS_IN_LEAP_P4_YEAR_PERIOD 
	};
	
	protected static final int[] P60_YEAR_PERIOD_DAYS_NON_LEAP = new int[] {
			DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
			DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
			DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
			DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
			DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
			DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
			DAYS_IN_LEAP_P4_YEAR_PERIOD, DAYS_IN_LEAP_P4_YEAR_PERIOD,
			DAYS_IN_NON_LEAP_P4_YEAR_PERIOD	
	};
		
	protected static final boolean[] P60_YEAR_PERIOD_ISLEAP_LEAP = new boolean[] {
		true, true, true, true, true, true, true, 
		true, true, true, true, true, true, true, true, 
	};
	
	protected static final boolean[] P60_YEAR_PERIOD_IS_LEAP_NON_LEAP = new boolean[] {
		true, true, true, true, true, true, true, 
		true, true, true, true, true, true, true, false, 
	};

	// --------------------------------------------------------------------------------------
	
	protected static final int DAYS_IN_LEAP_P60_YEAR_PERIOD = 21916;
	protected static final int DAYS_IN_NON_LEAP_P60_YEAR_PERIOD = 21915;
	
	protected static final int[] P420_YEAR_PERIOD_DAYS_LEAP = new int[] {
		DAYS_IN_NON_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_NON_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_NON_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_LEAP_P60_YEAR_PERIOD,
	};
	
	protected static final int[] P420_YEAR_PERIOD_DAYS_NON_LEAP = new int[] {
		DAYS_IN_NON_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_NON_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_NON_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_LEAP_P60_YEAR_PERIOD,
		DAYS_IN_NON_LEAP_P60_YEAR_PERIOD,
	};
	
	protected static final boolean[] P420_YEAR_PERIOD_ISLEAP_LEAP = new boolean[] {
		false, true, false, true, false, true, true
	};
	
	protected static final boolean[] P420_YEAR_PERIOD_IS_LEAP_NON_LEAP = new boolean[] {
		false, true, false, true, false, true, false
	};
	
	/**
	 * This field contains the year since the beginning of the Bulgarian Calendar.
	 */
	protected long mYear = 0;
	
	/**
	 * This field represents the month within the year. First month (Ignazhden) has index of zero (0). 
	 * The second month (Alem) has an index of one (1), and so on.... 
	 */
	protected int mMonthOfYear = 0;
	
	/**
	 * This field represents the daty within the month. Note that day indexes start from 0. In order to 
	 * convert them into human readable form, you have to increment it with 1.
	 */
	protected int mDayOfMonth = 0;
	
	/**
	 * 
	 */
	protected int mDayOfWeek = 0;
	
		
	protected void calculateWithinYear(long days, boolean isLeapYear) {
		int[] daysArray = null;
		if (isLeapYear) {
			daysArray = DAYS_IN_MONTH_LEAP_YEAR;
		} else {
			daysArray = DAYS_IN_MONTH_NON_LEAP_YEAR;
		}
		int sum = 0;
		for (int currentMonth = 0; currentMonth < daysArray.length; currentMonth++) {
			int daysInCurrentMonth = daysArray[currentMonth];
			if (days <= (sum + daysInCurrentMonth)) {
				mMonthOfYear = currentMonth;
				mDayOfMonth = (int)(days - sum);
				return;
			}
			sum = sum + daysInCurrentMonth;
		}
		throw new IllegalArgumentException("Days argument (" + days + 
				") shoud be less than the number of days within a "
				+ (isLeapYear ? " leap " : " non leap ") + " year: " + sum + ".");
	} 
	
	protected void calculateWithin4yearPeriod(long days, boolean isLeapPeriod) {
		int[] daysArray = null;
		boolean[] leapArray = null;
		if(isLeapPeriod) {
			daysArray = P4_YEAR_PERIOD_DAYS_LEAP;
			leapArray = P4_YEAR_PERIOD_ISLEAP_LEAP;
		} else {
			daysArray = P4_YEAR_PERIOD_DAYS_NON_LEAP;
			leapArray = P4_YEAR_PERIOD_IS_LEAP_NON_LEAP;
		}
		int sum = 0;
		for (int currentYear = 0; currentYear < daysArray.length; currentYear++) {
			int daysInYear = daysArray[currentYear];
			boolean isLeapYear = leapArray[currentYear];
			if (days <= sum + daysInYear) {
				calculateWithinYear(days - sum, isLeapYear);
				return;
			}
			sum = sum + daysInYear;
			mYear ++;
		}
		throw new IllegalArgumentException("Days argument (" + days 
				+ ") should be less than the number of days within a 4 year "
				+ (isLeapPeriod ? " leap " : " non leap ") + " period: " + sum + ".");
	}
	
	protected void calculateWithin60yearPeriod(long days, boolean isLeapPeriod) {
		int[] daysArray = null;
		boolean[] leapArray = null;
		if (isLeapPeriod) {
			daysArray = P60_YEAR_PERIOD_DAYS_LEAP;
			leapArray = P60_YEAR_PERIOD_ISLEAP_LEAP;
		} else {
			daysArray = P60_YEAR_PERIOD_DAYS_LEAP;
			leapArray = P60_YEAR_PERIOD_IS_LEAP_NON_LEAP;
		}
		int sum = 0;
		for (int current4yearPeriod = 0; current4yearPeriod < daysArray.length; current4yearPeriod ++) {
			int daysIn4YearPeriod = daysArray[current4yearPeriod];
			boolean isLeap4yearPeriod = leapArray[current4yearPeriod];
			if (days <= sum + daysIn4YearPeriod) {
				calculateWithin4yearPeriod(days - sum , isLeap4yearPeriod);
				return;
			}
			sum = sum + daysIn4YearPeriod;
			mYear = mYear + 4;
		}
		throw new IllegalArgumentException("Days argument ( " + days 
				+ ") should be less than the number of days within a 60 year "
				+ (isLeapPeriod ? " leap " : " non leap ") + " period: " + sum + "." );
	} 
	
    protected void calculateWithin420yearPeriod(long days, boolean isLeapPeriod) {
    	int[] daysArray = null;
    	boolean[] leapArray = null;
    	if (isLeapPeriod) {
    		daysArray = P420_YEAR_PERIOD_DAYS_LEAP;
    		leapArray = P420_YEAR_PERIOD_ISLEAP_LEAP;
    	} else {
    		daysArray = P420_YEAR_PERIOD_DAYS_NON_LEAP;
    		leapArray = P420_YEAR_PERIOD_IS_LEAP_NON_LEAP;
    	}
    	long sum = 0;
    	for (int current60yearPeriod = 0; current60yearPeriod < daysArray.length; current60yearPeriod++) {
    		int daysIn60yearPeriod = daysArray[current60yearPeriod];
    		boolean isLeap60yearPeriod = leapArray[current60yearPeriod];
    		if (days <= sum + daysIn60yearPeriod) {
    			calculateWithin60yearPeriod(days - sum, isLeap60yearPeriod);
    			return;
    		}
    		sum = sum + daysIn60yearPeriod;
    		mYear = mYear + 60;
    	}
    	throw new IllegalArgumentException("Days argument ( " + days 
    			+ ") should be less than the number of days within a 420 year "
    			+ (isLeapPeriod ? "leap"  : "non leap") + " period: " + sum + ".");
    }
	
	public static void main(String[] argv) {
		BgCalendar bgCalendar = new BgCalendar();
		int daysPassed = 1;
		bgCalendar.calculateWithin420yearPeriod(daysPassed, false);
		System.out.println("Month: " + MONTHS_NAMES_EN[bgCalendar.mMonthOfYear] 
		                             + "(" + MONTHS_NAMES_BG[bgCalendar.mMonthOfYear] + ")" 
		                             + ", Day: " + bgCalendar.mDayOfMonth + ", Year: " + bgCalendar.mYear + ".");
	}
	
}
