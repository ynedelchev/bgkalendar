package bg.util.leto.impl.bulgarian;

import java.util.HashMap;
import java.util.Locale;
import java.util.Map;

import bg.util.leto.api.LetoExceptionUnrecoverable;
import bg.util.leto.api.LetoPeriodStructure;
import bg.util.leto.base.LetoPeriodStructureBean;

public class LetoBulgarianMonth extends LetoPeriodStructureBean {
    
    private int mIndexInYear = 0;
    
    private static final Locale DEFAULT_LOCALE = Locale.ENGLISH;
    private static Map<Locale, String[]> sLocaleMonthNames = new HashMap<Locale, String[]>();
    private static Map<String, String[]> sLanguageMonthNames = new HashMap<String, String[]>();
    
    static {
        
        String[] BULGARIAN=new String[] {"Първи",  "Втори", "Трети",      "Четвърти",    "Пети",      "Шести", 
                                         "Седми",  "Осми",  "Девети",     "Десети",      "Единайсти",  "Дванайсти"};
        String[] RUSSIAN = new String[] {"First",    "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh",  "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] POLISH  = new String[] {"First",    "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh",  "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] CZECH  = new String[] {"First",    "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                        "Seventh",  "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] SLOVAK = new String[] {"First",    "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                        "Seventh",  "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] SLOVENIAN=new String[]{"First",    "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                        "Seventh",  "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] UKRAIN   = new String[]{"First",   "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] ROMANIAN = new String[]{"Firsth",  "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] SPANISH = new String[] {"First",   "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] GREEK   = new String[] {"First",   "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] TURKISH = new String[] {"First",   "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] DUTCH   = new String[] {"First",   "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] ESTONIAN= new String[] {"First",   "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] FINNISH = new String[] {"First",   "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};

        String[] ENGLISH = new String[] {"First",  "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] FRENCH  = new String[] {"First",  "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] GERMAN  = new String[] {"First",  "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] ITALIAN = new String[] {"First",  "Second",   "Third",     "Fourth",    "Fifth",    "Sixth", 
                                         "Seventh", "Eight",    "Ninth",     "Tenth",     "Eleventh", "Twelvth"};
        String[] JAPANESE= new String[] {"1 月",     "2 月",     "3 月",      "4 月",     "5 月",     "6 月", 
                                         "7 月",     "8 月",     "9 月",      "10 月",    "11 月",    "12 月"};
        String[] KOREAN  = new String[] {"1 월",  "2 월",  "3 월",  "4 월",  "5 월",     "6 월", 
                                                                                                            "7 월",  "8 월",   "9 월", "10 월", "11 월", "12 월"};
        String[] CHINESE = new String[] {"1 月", "2 月", "3 月",     "4 月",  "5 月",   "6 月", 
                        "7 月",  "8 月",   "9 月", "10 月", "11 月", "12 月"};
        
        
        sLanguageMonthNames.put("bg", BULGARIAN);   sLanguageMonthNames.put("bul", BULGARIAN);
        sLanguageMonthNames.put("бг", BULGARIAN);   sLanguageMonthNames.put("бъл", BULGARIAN);
        sLanguageMonthNames.put("ru", RUSSIAN);     sLanguageMonthNames.put("rus",  RUSSIAN);
        sLanguageMonthNames.put("pl", POLISH);      sLanguageMonthNames.put("pol",  POLISH);
        sLanguageMonthNames.put("cs", CZECH);       sLanguageMonthNames.put("cze",  CZECH);
        sLanguageMonthNames.put("ces", CZECH);   
        sLanguageMonthNames.put("sk", SLOVAK);      sLanguageMonthNames.put("slo",  SLOVAK);
        sLanguageMonthNames.put("slk", SLOVAK);   
        sLanguageMonthNames.put("sl", SLOVENIAN);   sLanguageMonthNames.put("slv", SLOVENIAN);
        sLanguageMonthNames.put("uk", UKRAIN);      sLanguageMonthNames.put("ukr", UKRAIN);
        sLanguageMonthNames.put("ro", ROMANIAN);    sLanguageMonthNames.put("ron", ROMANIAN);
        sLanguageMonthNames.put("rum", ROMANIAN); 
        sLanguageMonthNames.put("es", SPANISH);     sLanguageMonthNames.put("spa", SPANISH);
        sLanguageMonthNames.put("el", GREEK);       sLanguageMonthNames.put("ell", GREEK);
        sLanguageMonthNames.put("gre", GREEK);      sLanguageMonthNames.put("grc", GREEK);
        sLanguageMonthNames.put("tr", TURKISH);     sLanguageMonthNames.put("tur", TURKISH);
        sLanguageMonthNames.put("nl", DUTCH);       sLanguageMonthNames.put("dut", DUTCH);
        sLanguageMonthNames.put("nld", DUTCH);
        sLanguageMonthNames.put("et", ESTONIAN);    sLanguageMonthNames.put("est", ESTONIAN);
        sLanguageMonthNames.put("fi", FINNISH);     sLanguageMonthNames.put("fin", FINNISH);
        
        sLocaleMonthNames.put(Locale.ENGLISH,      ENGLISH);
        sLocaleMonthNames.put(Locale.CANADA,       ENGLISH);
        sLocaleMonthNames.put(Locale.UK,           ENGLISH);
        sLocaleMonthNames.put(Locale.US,           ENGLISH);
        sLocaleMonthNames.put(Locale.getDefault(), ENGLISH);
        sLocaleMonthNames.put(Locale.FRENCH,  FRENCH);
        sLocaleMonthNames.put(Locale.FRANCE,  FRENCH);
        sLocaleMonthNames.put(Locale.CANADA_FRENCH, FRENCH);
        sLocaleMonthNames.put(Locale.GERMAN,        GERMAN);
        sLocaleMonthNames.put(Locale.GERMANY,       GERMAN);
        sLocaleMonthNames.put(Locale.ITALIAN,       ITALIAN);
        sLocaleMonthNames.put(Locale.ITALY,         ITALIAN);
        sLocaleMonthNames.put(Locale.JAPANESE,      JAPANESE);
        sLocaleMonthNames.put(Locale.JAPAN,         JAPANESE);
        sLocaleMonthNames.put(Locale.KOREAN,        KOREAN);
        sLocaleMonthNames.put(Locale.KOREA,         KOREAN);
        sLocaleMonthNames.put(Locale.CHINESE,             CHINESE);
        sLocaleMonthNames.put(Locale.CHINA,               CHINESE);
        sLocaleMonthNames.put(Locale.PRC,                 CHINESE);
        sLocaleMonthNames.put(Locale.SIMPLIFIED_CHINESE,  CHINESE);
        sLocaleMonthNames.put(Locale.TRADITIONAL_CHINESE, CHINESE);

        
    }
    
    /**
     * Create new Month representation objec that would be able to return the name ofthe month based on its index 
     * within the year and the target locale.
     * @param totalLengthInDays
     * @param subPeriods
     * @param indexInYear Index of the month withing the year, starting from 0. Zero is for January. 1 is for February.
     *        11 is for December.
     */
    public LetoBulgarianMonth(long totalLengthInDays, LetoPeriodStructure[] subPeriods, int indexInYear) 
    {
        super(totalLengthInDays, subPeriods);
        mIndexInYear = indexInYear;
        if (mIndexInYear < 0 || mIndexInYear >= 12) {
            throw new LetoExceptionUnrecoverable("No month with index " + indexInYear 
                   + " is supported in Gregorian calendar. Its index shoul be between 0 (January) and 11 (December).");
        }
    }
    
    
    /**
     * Create new Month representation objec that would be able to return the name ofthe month based on its index 
     * within the year and the target locale.
     * @param totalLengthInDays
     * @param subPeriods
     * @param indexInYear Index of the month withing the year, starting from 0. Zero is for January. 1 is for February.
     *        11 is for December.
     */
    public LetoBulgarianMonth(LetoPeriodStructureBean bean, int indexInYear) 
    {
        this(bean.getTotalLengthInDays(), bean.getSubPeriods(), indexInYear);
    }
    
    @Override
    public String getName(Locale locale) {
        String[] months = null;
        if (locale != null) {
            months = sLocaleMonthNames.get(locale);
            if (months == null) {
                String languageName = null;
                try { 
                    languageName = locale.getISO3Language();
                } catch (Throwable t) {
                }
                if (languageName != null) {
                    languageName = languageName.toLowerCase().trim();
                    months = sLanguageMonthNames.get(languageName);
                }
            }
        }
        if (months == null) {
            months = sLocaleMonthNames.get(DEFAULT_LOCALE);
        }
        
        return months[mIndexInYear];
    }
}
