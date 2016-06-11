package bg.util.leto.impl.gregorian;

import java.util.HashMap;
import java.util.Locale;
import java.util.Map;

import bg.util.leto.api.LetoExceptionUnrecoverable;
import bg.util.leto.api.LetoPeriodStructure;
import bg.util.leto.base.LetoPeriodStructureBean;

public class LetoGregorianMonth extends LetoPeriodStructureBean {
    
    private int mIndexInYear = 0;
    
    private static final Locale DEFAULT_LOCALE = Locale.ENGLISH;
    private static Map<Locale, String[]> sLocaleMonthNames = new HashMap<Locale, String[]>();
    private static Map<String, String[]> sLanguageMonthNames = new HashMap<String, String[]>();
    
    static {
        
        String[] BULGARIAN=new String[] {"Януари",  "Февруари", "Март",      "Април",    "Май",      "Юни", 
                                         "Юли",     "Август",   "Септември", "Октомври", "Ноември",  "Декември"};
        String[] RUSSIAN = new String[] {"Январь",  "Февраль",  "Март",      "Апрель",    "Май",      "Июнь", 
                                         "Июль",    "Август",   "Сентябрь",  "Октябрь",   "Ноябрь",  "Декабрь"};
        String[] POLISH  = new String[] {"Stycznia","Lutego",   "Marca",     "Kwietnia",  "Maja",    "Czerwca", 
                                         "Lipca",   "Sierpnia", "Września",  "Października","Listopada", "Grudnia"};
        String[] CZECH  = new String[] {"Leden",    "Únor",     "Březen",    "Duben",     "Květen",  "Červen", 
                                        "Červenec", "Srpen",    "Září",      "Říjen",     "Listopad","Prosinec"};
        String[] SLOVAK = new String[] {"Január",   "Február",  "Marca",     "Apríl",     "Môže",    "Júna", 
                                        "Júla",     "Augusta",  "Septembra", "Októbra",   "November","Decembra"};
        String[] SLOVENIAN=new String[]{"Januarja", "Februarja","Marca",     "April",     "Lahko",   "Junija", 
                                        "Julija",   "Avgusta",  "September", "Oktober",   "Novembra","Decembra"};
        String[] UKRAIN   = new String[]{"Січень",  "Лютий",    "Березня",   "Квітень",   "Травень", "Червень", 
                                         "Липень",  "Сер",      "Вересень",  "Жовтень",   "Листопад","Грудень"};
        String[] ROMANIAN = new String[]{"Ianuarie","Februarie","Martie",    "Aprilie",   "Poate",   "Iunie", 
                                         "Iulie",   "August",   "Septembrie","Octombrie", "Noiembrie","Decembrie"};
        String[] SPANISH = new String[] {"Enero",   "Febrero",  "Marzo",     "Abril",    "Mayo",     "Junio", 
                                         "Julio",   "Agosto",   "Septiembre","Octubre",  "Noviembre","Diciembre"};
        String[] GREEK   = new String[] {"Ιανουαρίου","Φεβρουαρίου","Μαρτίου", "Απριλίου", "Μπορεί να","Ιουνίου", 
                                        "Ιουλίου",   "Αύγουστος","Σεπτεμβρίου","Οκτωβρίου","Νοεμβρίου","Δεκεμβρίου"};
        String[] TURKISH = new String[] {"Ocak",    "Şubat",    "Mart",      "Nisan",    "May",      "Haziran", 
                                         "Temmuz",  "Ağustos",  "Eylül",     "Ekim",     "Kasım",    "Aralık"};
        String[] DUTCH   = new String[] {"Januari", "Februari", "Maart",     "April",    "Mei",      "Juni", 
                                         "Juli",    "Augustus", "September", "Oktober",  "November", "December"};
        String[] ESTONIAN= new String[] {"Jaanuar", "Veebruar", "Märts",     "Aprill",   "Võib",     "Juuni", 
                                         "Juuli",   "August",   "September", "Oktoober", "November", "Detsember"};
        String[] FINNISH = new String[] {"Tammikuuta", "Helmikuuta", "Maaliskuuta",     "Huhtikuuta",    "Voi",       
                                         "Kesäkuuta", 
                                         "Heinäkuuta",    "Elokuu",   "Syyskuuta", "Lokakuuta",  "Marraskuuta", 
                                         "Joulukuuta"};

        String[] ENGLISH = new String[] {"January", "February", "March",     "April",    "May",       "June", 
                                         "July",    "August",   "September", "October",  "November", "December"};
        String[] FRENCH  = new String[] {"Janvier", "Février",  "Mars",      "Avril",    "Mai",      "Juin", 
                                         "Juillet", "Août",     "Septembre", "Octobre",  "Novembre", "Décembre"};
        String[] GERMAN  = new String[] {"Januar",  "Februar",  "März",      "April",    "Mai",      "Juni", 
                                         "Juli",    "August",   "September", "Oktober",  "November", "Dezember"};
        String[] ITALIAN = new String[] {"Gennaio", "Febbraio", "Marzo",     "Aprile",   "Maggio",   "Giugno", 
                                         "Luglio",  "Agosto",   "Settembre", "Ottobre",  "Novembre", "Dicembre"};
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
    public LetoGregorianMonth(long totalLengthInDays, LetoPeriodStructure[] subPeriods, int indexInYear) 
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
    public LetoGregorianMonth(LetoPeriodStructureBean bean, int indexInYear) 
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
