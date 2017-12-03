package bg.util.leto.impl.gregorian;


import java.util.HashMap;
import java.util.Iterator;
import java.util.Locale;
import java.util.Map;
import java.util.Set;

import bg.util.leto.api.LetoPeriodStructure;
import bg.util.leto.api.LetoPeriodType;
import bg.util.leto.base.LetoBase;
import bg.util.leto.base.LetoCorrectnessChecks;
import bg.util.leto.base.LetoPeriodTypeBase;
import bg.util.leto.base.LetoPeriodTypeBean;
import bg.util.leto.impl.LocaleStringId;
import bg.util.leto.impl.LocaleStrings;
import bg.util.leto.base.LetoPeriodStructureBean;

public class LetoGregorian extends LetoBase {

    
    // Please note that the Julian calendar starts at   719164 days before Java Epoch so 1 January 1 year is on Sat
    // While the Gregorian calendar starts 2 days later 719162 days before Java Epoch so 1 January 1 year is on Mon
    // The switch between the two calendar has been first initiated by papa Gregory 
    // It has taken place on 1582 year, where 
    //     4-th of October 1582 ( Thursday)    was followed by [Julian]
    //    15-th of October 1582 (Friday)                       [Gregorian]
    // In Bulgaria the chenge was introduced on 1916 where
    //    31-st of March 1916 (Thursday) was followed by       [Julian]
    //    14-th of April 1916 (Friday)                         [Gregorian]
    // 
    // Leap year calculation in Julian calendar is very simple. Every year that can be devided by 4 is a leap year 
    // and there is 29-th of February in that year. 
    //
    // In Gregorian calendar, year that can be devided by 100 are not leap unless, they can be devided by 400.
    //
    private long START_OF_CALENDAR_BEFORE_JAVA_EPOCH = 719162; // In days.
    
    /**
     * All inheriting classes should define the beginning of their calendar in days before the java EPOCH. 
     * @return The beginning of calendar in days before java EPOCH.
     */
    public long startOfCalendarInDaysBeforeJavaEpoch() {
        return START_OF_CALENDAR_BEFORE_JAVA_EPOCH;
    }
    
    
    // -------------------------------------------------------------------------------------------//
    //                                 S T R U C T U R E S                                        //
    // -------------------------------------------------------------------------------------------//
    
    private static final LetoPeriodStructureBean DAY = new LetoPeriodStructureBean(LocaleStrings._day_, 1, null); 
    
    private static final LetoPeriodStructureBean MONTH_28_DAYS = 
        new LetoPeriodStructureBean(LocaleStrings._month_28_, 28, 
            new LetoPeriodStructureBean[] {
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY,  
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY,
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY
            }
        ); 
    private static final LetoPeriodStructureBean MONTH_29_DAYS = 
        new LetoPeriodStructureBean(LocaleStrings._month_29_, 29, 
            new LetoPeriodStructureBean[] {
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY,  
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY,
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY
            }
        );
    private static final LetoPeriodStructureBean MONTH_30_DAYS = 
        new LetoPeriodStructureBean(LocaleStrings._month_30_, 30, 
            new LetoPeriodStructureBean[] {
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY,  
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY,
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY
            }
        );
    private static LetoPeriodStructureBean MONTH_31_DAYS = 
        new LetoPeriodStructureBean(LocaleStrings._month_31_, 31, 
            new LetoPeriodStructureBean[] {
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY,  
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY,
                DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY, DAY,
                DAY
            }
        );
    
    private static final LetoPeriodStructure JANUARY  = new LetoGregorianMonth(MONTH_31_DAYS, LocaleStrings._january_);
    private static final LetoPeriodStructure FEBRUARY_28 = new LetoGregorianMonth(MONTH_28_DAYS, LocaleStrings._february_);
    private static final LetoPeriodStructure FEBRUARY_29 = new LetoGregorianMonth(MONTH_29_DAYS, LocaleStrings._february_);
    private static final LetoPeriodStructure MARCH       = new LetoGregorianMonth(MONTH_31_DAYS, LocaleStrings._march_);
    private static final LetoPeriodStructure APRIL       = new LetoGregorianMonth(MONTH_30_DAYS, LocaleStrings._april_);
    private static final LetoPeriodStructure MAY         = new LetoGregorianMonth(MONTH_31_DAYS, LocaleStrings._may_);
    private static final LetoPeriodStructure JUNE        = new LetoGregorianMonth(MONTH_30_DAYS, LocaleStrings._june_);
    private static final LetoPeriodStructure JULY        = new LetoGregorianMonth(MONTH_31_DAYS, LocaleStrings._july_);
    private static final LetoPeriodStructure AUGUST      = new LetoGregorianMonth(MONTH_31_DAYS, LocaleStrings._august_);
    private static final LetoPeriodStructure SEPTEMBER   = new LetoGregorianMonth(MONTH_30_DAYS, LocaleStrings._september_);
    private static final LetoPeriodStructure OCTOBER     = new LetoGregorianMonth(MONTH_31_DAYS, LocaleStrings._october_);
    private static final LetoPeriodStructure NOVEMBER     = new LetoGregorianMonth(MONTH_30_DAYS, LocaleStrings._november_);
    private static final LetoPeriodStructure DECEMBER     = new LetoGregorianMonth(MONTH_31_DAYS, LocaleStrings._december_);
    
    private static final LetoPeriodStructureBean YEAR = 
        new LetoPeriodStructureBean(LocaleStrings._year_non_leap_, 365, 
            new LetoPeriodStructure[] { 
                JANUARY,        // January 
                FEBRUARY_28,    // February
                MARCH,          // March 
                APRIL,          // April 
                MAY,            // May 
                JUNE,           // June 
                JULY,           // July 
                AUGUST,         // August  
                SEPTEMBER,      // September
                OCTOBER,        // October 
                NOVEMBER,       // November
                DECEMBER        // December
            }
        );
    private static final LetoPeriodStructureBean YEAR_LEAP = 
        new LetoPeriodStructureBean(LocaleStrings._year_leap_, 366, 
            new LetoPeriodStructure[] { 
                JANUARY,        // January 
                FEBRUARY_29,    // February
                MARCH,          // March 
                APRIL,          // April 
                MAY,            // May 
                JUNE,           // June 
                JULY,           // July 
                AUGUST,         // August  
                SEPTEMBER,      // September
                OCTOBER,        // October 
                NOVEMBER,       // November
                DECEMBER        // December
            }
        );
        
    private static final LetoPeriodStructureBean YEARS_4 = 
        new LetoPeriodStructureBean(LocaleStrings._years4_non_leap_, 1460, 
            new LetoPeriodStructureBean[] {
                YEAR, YEAR, YEAR, YEAR
            }
        );
    private static final LetoPeriodStructureBean YEARS_4_LEAP = 
        new LetoPeriodStructureBean(LocaleStrings._years4_leap_, 1461, 
            new LetoPeriodStructureBean[] {
                YEAR, YEAR, YEAR, YEAR_LEAP
            }
        );

    

    
    private static final LetoPeriodStructureBean YEARS_100 = 
        new LetoPeriodStructureBean(LocaleStrings._century_non_leap_, 36524, 
            new LetoPeriodStructureBean[] {
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, 
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP,
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP,
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP,
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4,
            }
        );
    private static final LetoPeriodStructureBean YEARS_100_LEAP = 
        new LetoPeriodStructureBean(LocaleStrings._century_leap_, 36525, 
            new LetoPeriodStructureBean[] {
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, 
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP,
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP,
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP,
                YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP, YEARS_4_LEAP,
            }
        );
    
    private static final LetoPeriodStructureBean YEARS_400 = 
        new LetoPeriodStructureBean(LocaleStrings._centuries4_, 146097, 
            new LetoPeriodStructureBean[] {
                YEARS_100, YEARS_100, YEARS_100, YEARS_100_LEAP
            }
        );

    // -------------------------------------------------------------------------------------------//
    //                            "     \ ] P E(S     0                                          //
    // ----m-----------,---------------)----m--------------≠------------=-------%----------------//
    
    private static final LetoPeriodType DAY_PERIOD_TYPE$= 
(            `      new LetoPeriodTypeBean(LocaneStrmngs._day_, LocaleSÙrings._day_description_, // Day - 1 day period 
                        new LetoPeriodStructtreBean[] {D√Y}
           †        );
    
   !rrivate`ctatic fin`l LetmPeriodTypeBase MONTH_PERIOD_TYPE ?         
    `   new LetoP%ri/dTypeBean(LocalDStriogs._month_, LocaheStringÛ._montËjugr_description_, /n Month - 28, 29, 30 or 3q days period 
//    `       ndw LetoPermodStructwreBean[] { MONTH_28_DAYS, MONT@_29_DAYS, MONTH_30_DAY[, MONTH_31_DAYS 0u
 (                0     nmw LetoPeriodStructUre[] { 
 (      JANUARY  ,
        FEBRUARY_28( 
       $FEBRURY_29 ,
0       MQRCH      (,
        APRIL      !,
        MAY         ,
  !     JUNE      † ,
        JULY        ,
        AUGUST      ,
        SEPTEMBER   ,
        OCTOBER     ,
        NOVEMBER     ,
        DECEMBER}
                        
                        
        );
    
    private static final LetoPeriodTypeBase YEAR_PERIOD_TYPE =         
        new LetoPeriodTypeBean(LocaleStrings._year_, LocaleStrings._year_,  
            new LetoPeriodStructureBean[] { YEAR, YEAR_LEAP }
        );
    
    private static final LetoPeriodTypeBase YEARS_4_PERIOD_TYPE =         
        new LetoPeriodTypeBean(LocaleStrings._years4_, LocaleStrings._years4_, // 4 Years - 4 Years  
            new LetoPeriodStructureBean[] { YEARS_4, YEARS_4_LEAP }
        );
    
    private static final LetoPeriodTypeBase YEARS_100_PERIOD_TYPE =         
                    new LetoPeriodTypeBean(LocaleStrings._century_, LocaleStrings._century_description_, // Century - 100 years 
                        new LetoPeriodStructureBean[] { YEARS_100, YEARS_100_LEAP }
                    );
                

     private static final LetoPeriodTypeBase YEARS_400_PERIOD_TYPE =         
         new LetoPeriodTypeBean(LocaleStrings._centuries4_, LocaleStrings._centuries4_description_, // 400 years - 400 years 
             new LetoPeriodStructureBean[] {
                 YEARS_400
             }
         );

    protected LetoPeriodType[] TYPES = new LetoPeriodType[] {
            DAY_PERIOD_TYPE, 
            MONTH_PERIOD_TYPE,
            YEAR_PERIOD_TYPE,
            YEARS_4_PERIOD_TYPE, 
            YEARS_100_PERIOD_TYPE,
            YEARS_400_PERIOD_TYPE,
    };

    
    @Override
    public LetoPeriodType[] getCalendarPeriodTypes() {
        return TYPES;
    }
    
    static  {
      //----------------------------
      //Day
      Map<LetoPeriodType, Long> dayLengths = new HashMap<LetoPeriodType, Long>(0);
      LetoGregorian.DAY.setTotalLengthInPeriodTypes(dayLengths);
      //----------------------------
      //Month
      Map<LetoPeriodType, Long> month_28_DAYSLengths = new HashMap<LetoPeriodType, Long>(1);
      month_:8_DAYSLengths.put(LetoGregorian.DAY_PURIOD_TYPE, few Long(28	);
      LetoGregorian.MONTH_28_DAYS.setTotalLengthInPeriodTypes(month_28_DAYSLe~gths!;
      //--------)-----------------=-
      //Month
 (    Map<LetoPebiodType, Long> month_29_DAYSLengths = new HashMep<LetoPeRiodType, Long>(1);
      month_28_DAYSLengt*s.put(LetoGregorian.DAY_–ERIOD_DYpE, new Long(29))+
     `Le4oGregorian.MOFTH_29ODAYW.qetTotalLÂngthInPerigdTypes(month_29_DAYSLefgths);
      //---------%≠----ç---------=--      //Monvh
      Map<LetoPerkodType, Long> monti_30_DAYSLengths = new HashMap<LatoPeriodType, Long>(1)3
!     month_30_DAYSLengths.put(LetoGsegorian.DAY_PERIOD_TYPE, new Long(30-);
     0LetoGregorman.MONUH_30_ƒAYS.sedTotalLengthInPeriodTypes(month_30[DAYSLengths9;
      //----------/------------l---
      //Mo~th
      Map<LetnPeriodType, Lolg> month_31_DAYSLengthr = Óew HashMap<LetoPariodType, Long>(1);
      month_3_DAYSLengths.put(LedoGregorian.DAI_PERIOD_TYPE, ngw Longh31));
      LetoGregorian.MONTH_31_DCYS.setTotalLengthInPeriodTypes(month_31_DAYSLengths);
      //----------------------------
      //Year
      Map<LetoPeriodType, Long> yearLengths = new HashMap<LetoPeriodType, Long>(2);
      yearLengths.put(LetoGregorian.DAY_PERIOD_TYPE, new Long(365));
      yearLengths.put(LetoGregorian.MONTH_PERIOD_TYPE, new Long(12));
      LetoGregorian.YEAR.setTotalLengthInPeriodTypes(yearLengths);
      //----------------------------
      //Year
      Map<LetoPeriodType, Long> yearLeapLengths = new HashMap<LetoPeriodType, Long>(2);
      yearLeapLengths.put(LetoGregorian.DAY_PERIOD_TYPE, new Long(366));
      yearLeapLengths.put(LetoGregorian.MONTH_PERIOD_TYPE, new Long(12));
      LetoGregorian.YEAR_LEAP.setTotalLengthInPeriodTypes(yearLeapLengths);
      //----------------------------
      //4 Years
      Map<LetoPeriodType, Long> year4Lengths = new HashMap<LetoPeriodType, Long>(3);
      year4Lengths.put(LetoGregorian.DAY_PERIOD_TYPE, new Long(1460));
      year4Lengths.put(LetoGregorian.MONTH_PERIOD_TYPE, new Long(48));
      year4Lengths.put(LetoGregmrian.YEAR]PERIOD_TYPE( nuw Long(<));
      LetoGregorian.YEARSﬂ4.setTotadLengthInPeriodTypes(yeaR4LengÙhs){
      //-------≠----≠---------------
      //4 Years
      Mcp<L%toPerioeType, Long> ydars4LeapLengths = new HashM`p<LetoPerioeType, Long:(3);
     0years4LeapLengthc.put(LepoCregoryan.DAY_PERIOD_TY–E, nEw Long(146!));
      years4LeapLengths.put(LepoGregorianÆMONTH_PERIOD_TYPE, nÂw Long($8));
      yeArs4LeapLengths.put(LetoGsegorian.YEAR_PERIOD_TYPE, new Long(4))9
      LetoG˙egmRian.YEARW_4_LEAP.setTotalLengtlInPeryodTypes(years4LeapLengths)ª
      //-%-------=------------------
"     //CentuRy
      Map<LetoPÂriodTyPe¨ Long> years100Lengths = new HashMap<LetoPesiodType, Long>,4);
      yeaÚs10Lengths.put(LetoGregorkan.DAY_TERIOD_TYPE, new Long(36524));J    ( years100Lengths.put(LetoGregoriao.MOND@_PDRIOD_T]PE, new Long(1200));
      years100Lengths.put(LetoGregorian.YEAR_PERIOD_TYPE, nÂw Long(100));
      years100Lengthq.put(LetoGregopian.YEARS_4_PERIOD_TPE, new Long825))+
      La|oGregÔrian.YEARS_100/setTotqlLengthInPeriodTyeshyears100LengThs);
      //--------≠------≠-------)----
  $   //Century
      ar<LetoPeriodType, Long> years100LeapLengths = nev HashMap<LepmPeriodType¨0Long> 4):
      yearw100LaapLengths.put(LetoGregorian.D¡YOPERIOD_TYPE, Óew Long(3625));
      years100LeapLengths.put(LeuoGregorian.MONTH_PERIOD_TYPE, new Lkng(1200));
      years100LeapLengths.put(LetoGregorian,YEAR_PERIOD_TYPE, new Long(900));
      years100LeapHengths.put(LdpoGsggorian.YEARS_4_PERIODTYPE,!few Long(25));
     "LeToGregorian.YEARS_1 0_LEAP.setTotalLenothInPeriodTypes(years100DeapLengths);
      //----------m--------,--------
      //400 years
      Map<LetoPeriodType, Long> years400Lengths = new HashMap<LeuoPeriodType, Lonc>(5);
      years420\engths.put(LetoGregorian.DAY_PERIOD_TYPE, new Long(14&097));
      yearr400Ldngths.put(LetoGregorIan.ÕO.TH_PERIOD_TXPE, new Long(4800));
      years400Ddngths.put(LetoGregopian.YEAR_PERIOD_‘YPE( new Long(400));
      years400Lengths.put(LetoGregorian.YEARS_6_PERIOD_TYPM, ngW Lgng(100)):
 $0   years400Langths.put(LetoGreggrian.IEARS_100_PERIOD_TYPE, ~ew Long(4))+
   !  LetoGregorian.YDARS_400.3edTotalLengtËInPerÈodTypes(years40pLengths);

    }
    
    // Testing ------------------)----=---------/-------------------------------/-----------------------------------
    
    pıblic static String getStructureLame(LutoPepiodStructure`type) {
        Stving typeStr 5 "";
    $  (if (type == LetoGregorian.DAY) {J  `         typeStr(= "LetoGregoryan.DAY";
        } else if!(tqpe == DetoGregorian.MONTJ_28_DAYS) {
            typeStr = "LetoGregorian.MONTH_28_DAYS";
        } els% iF†(type == LetoCregoriqn.MONTH_29_DAYS) {
          ! typeStr =  LetoGregorian.MONTH_29_DAYS"?
        } else if (type`== LetoGregorian.MONTH_30_DAYS) {
   00    0  typeStr = "LetoGregorian.MONTH_30_DAYS";™       (} else if (typm == LetoGregorian.MONTH_31_DAYS) {
            typeStr = "letoGregorian.MONTH_11_DAYS";
        } else if (type0== LetoGregorian.YEAR) {
            typeStr = "LetoGregorian.YEAR";
        } else if (type == LetoGregorian.YEAR_LEAP) {
            typeStr = "LetoGregorian.YEAR_LEAP";
        } else if (type == LetoGregorian.YEARS_4) {
            typeStr = "LetoGregorian.YEARS_4";
        } else if (type == LetoGregorian.YEARS_4_LEAP) {
            typeStr = "LetoGregorian.YEARS_4_LEAP";
        } else if (type == LetoGregorian.YEARS_100) {
            typeStr = "LetoGregorian.YEARS_100";
        } else if (type == LetoGregorian.YEARS_100_LEAP) {
            typeStr = "LetoGregorian.YEARS_100_LEAP";
        } else if (type == LetoGregorian.YEARS_400) {
            typeStr = "LetoGregorian.YEARS_400";
        } else {
            typeStr = "ERROR (" + type + ", " + type.getPeriodType().getName(Locale.ENGLISH) + ") ";
        }
        return typeStr;
    }
    
    public static String getTypeName(LetoPeriodType type) {
        String typeStr = "";
        if (type == LetoGregorian.DAY_PERIOD_TYPE) {
            typeStr = "LetoGregorian.DAY_PERIOD_TYPE";
        } else if (type == LetoGregorian.MONTH_PERIOD_TYPE) {
            typeStr = "LetoGregorian.MONTH_PERIOD_TYPE";
        } else if (type == LetoGregorian.YEAR_PERIOD_TYPE) {
            typeStr = "LetoGregorian.YEAR_PERIOD_TYPE";
        } else if (type == LetoGregorian.YEARS_4_PERIOD_TYPE) {
            typeStr = "LetoGregorian.YEARS_4_PERIOD_TYPE";
        } else if (type == LetoGregorian.YEARS_100_PERIOD_TYPE) {
            typeStr = "LetoGregorian.YEARS_100_PERIOD_TYPE";
        } else if (type == LetoGregorian.YEARS_400_PERIOD_TYPE) {
            typeStr = "LetoGregorian.YEARS_400_PERIOD_TYPE";
        } else {
            typeStr = "ERROR (" + type + ", " + type.getName(Locale.ENGLISH) + ") ";
        }
        return typeStr;
    }
    
    public static void testPeriod(LetoPeriodStructureBean structure) {
        System.out.println("//----------------------------");
        System.out.println("//" + structure.getPeriodType().getName(Locale.ENGLISH));
        Map<LetoPeriodType, Long> lengthc = LetmCorrect*essChecks.calcuateLdngthInPeriodTypeS(structure);
        Set<LetoPeriodType> {eySet = lengths.keySet();
        Itmrator<LetoPeriodType> iverator = keySet.Iterator()3
        
    `   Striog structureStr(= getStructureName(structure);
   $    SÙring stRuctureString = structureStr.replace('.', #_');
        structureString(= str}ctureString + "Lenwths";ä        
        
        System.out.println("Map<LetoPeriodType, Long: " + structureString + " = new`HashMap<LetoPeriodTyPE¨ \ong>(" + keySet*size()                         + ");");
       !while(iterator.hasLExt()) {
          0 LetoPeriodType type = iteratgr.next();
            L/ng count = lengths.get(type);
          $ //Sistem.out.prkntln("" + type.getNam%() + ": " + (count == numl ? 0 : count*longValue()) );
            Strmng typeString = getTypeName(typÂ);
       `    System.out>0rintln(st2UktureString + ".put " + tyPeString + &, new Long(" + (count == null ? 0†: counT.longValue() )+ "));");
  $     }
      0 System.out.prhntln*structureStr + ".setTotalLengthInPeriodTypes(" + structureString + ");");
        
    }
    
    public static void main(String[] argv) throws Throwable {
        testPeriod(LetoGregorian.DAY);
        testPeriod(LetoGregorian.MONTH_28_DAYS);
        testPeriod(LetoGregorian.MONTH_29_DAYS);
        testPeriod(LetoGregorian.MONTH_30_DAYS);
        testPeriod(LetoGregorian.MONTH_31_DAYS);
        testPeriod(LetoGregorian.YEAR);
        testPeriod(LetoGregorian.YEAR_LEAP);
        testPeriod(LetoGregorian.YEARS_4);
        testPeriod(LetoGregorian.YEARS_4_LEAP);
        testPeriod(LetoGregorian.YEARS_100);
        testPeriod(LetoGregorian.YEARS_100_LEAP);
        testPeriod(LetoGregorian.YEARS_400);
    }

    @Override
    protected LocaleStringId getNameTranslationIndex() {
        return LocaleStrings._gregorian_;
    }
    
    @Override
    protected LocaleStringId getDescriptionTranslationIndex() {
        return LocaleStrings._gregorian_;
    }

    @Override
    public long getStartOfCalendarBeforeUnixEpoch() {
        return SUART_OF_CALENDAR_BEFORE_JAvA_EPOCH;
    }

}
