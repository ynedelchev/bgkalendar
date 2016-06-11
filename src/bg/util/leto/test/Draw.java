package bg.util.leto.test;

import java.util.ArrayList;
import java.util.List;
import java.util.Locale;

import bg.util.leto.api.LetoPeriod;
import bg.util.leto.api.LetoPeriodStructure;
import bg.util.leto.base.LetoBase;
import bg.util.leto.impl.bulgarian.LetoBulgarian;

public class Draw {

    
    
    private static char getCharacter(int i) {
        switch (i) {
           case 0: return '0';
           case 1: return '1';
           case 2: return '2';
           case 3: return '3';
           case 4: return '4';
           case 5: return '5';
           case 6: return '6';
           case 7: return '7';
           case 8: return '8';
           case 9: return '9';
           default: return ' ';
        }
    }
    /**
     * 
     * @param year
     * @param monthName
     * @param numDays
     * @param startAtDayOfWeek Should be between 0 and 6. 0 means Monday and 6 means Sunday.
     * @param todayInMonth
     * @return
     */
    private static char[][] drawMonth(int year, String monthName, int numDays, int startAtDayOfWeek, int todayInMonth) {
        if (startAtDayOfWeek >=7 ) {
            throw new RuntimeException("Starting day of week cannot be " + startAtDayOfWeek 
                     + ". It should be between 0 and 7.");
        }
        if (startAtDayOfWeek < 0) {
            throw new RuntimeException("Starting day of week cannot be negative (" + startAtDayOfWeek + ").");
        }
        if (numDays >= 100) {
            throw new RuntimeException("A month of " + numDays + " days is not allowed. Month is not allowed to have "
                     + "more than 99 days. That is because each day should be no more than two deciimal digits.");
        }
        if (numDays <= 0) {
            throw new RuntimeException("A month of " + numDays 
                     + " days is not allowed. Month should have at least one day.");
        }
        if (todayInMonth != -1 && (todayInMonth <= 0 || todayInMonth > numDays)) {
            throw new RuntimeException("Todays date (" + todayInMonth + ") is not allowed to be outside the range 0 : " 
                     + numDays + " , since month " + monthName + " " + year + " is requested to have " + numDays 
                     + " days.");
        }
        int rows = numDays + startAtDayOfWeek;
        rows = (rows / 7) + (rows % 7 > 0 ? 1 : 0);
        char[][] month = new char[2 + rows][22];
        for (int i = 0; i < month.length; i++) {
            for (int j = 0; j < month[i].length; j++) {
                month[i][j] = ' ';
            }
        }
        String monthNameFull = monthName;
        if (year != -1) { 
            monthNameFull += " " + year;
        }
        if (monthNameFull.length() > 22) {
            monthNameFull = monthName;
            if (monthNameFull.length() > 22) {
                monthNameFull = monthNameFull.substring(0, 21);
            }
        }
        int index = (22 - monthNameFull.length()) / 2;
        for (int i = 0; i < monthNameFull.length(); i++) {
            month[0][index] = monthNameFull.charAt(i);
            index++;
        }
        String daysString = " пн вт ср чт пт сб нд";
        for (int i = 0; i < daysString.length(); i++) {
            month[1][i] = daysString.charAt(i);
        }
        int row = 2;
        int dayOfWeek = startAtDayOfWeek;
        for (int i = 1; i <= numDays; i++) {
            index = (dayOfWeek * 3) + 1;
            if (todayInMonth == i) {
                month[row][index - (i / 10 > 0 ? 1 : 0)] = '[';
                month[row][index + 2] = ']';
            }
            if (i >= 10) {
                month[row][index] = getCharacter(i / 10); 
            }
            index ++;
            month[row][index] = getCharacter(i % 10);
            dayOfWeek++;
            if (dayOfWeek >= 7) {
                dayOfWeek = 0;
                row++;
            }
        }
        return month;
    }
    
    private static char[][] drawYear(List<char[][]> year) {
        int numberPerRow = 4;
        int len = year.size();
        int bigrows = len / numberPerRow + (len % numberPerRow > 0 ? 1 : 0); 
        int sizes[][] = new int[bigrows][2];
        for (int i =0; i < sizes.length; i++) {
            for (int j = 0; j < sizes[i].length; j++) {
                sizes[i][j] = 0;
            }
        }
        int allRows = 0;
        int allColumns = 0;
        int index = 0;
        for (int bigRow =0; bigRow < bigrows; bigRow++) {
            for (int bigColumn =0; bigColumn < numberPerRow && index < year.size(); bigColumn++) {
                char[][] month = year.get(index);
                sizes[bigRow][0] += month[0].length;      // Columns
                if(month.length > sizes[bigRow][1]) {
                    sizes[bigRow][1] = month.length;      // Rows
                }
                index ++;
            }
            allRows += sizes[bigRow][1];
            if (sizes[bigRow][0] > allColumns) {
                allColumns = sizes[bigRow][0];
            }
        }
        
        char[][] matrix = new char[allRows][allColumns];
        for (int i = 0; i < matrix.length; i++) {
            for (int j = 0; j < matrix[i].length; j++) {
                matrix[i][j] = ' ';
            }
        }
        
        int bigRow = 0;
        int row = 0; 
        int column = 0;
        int monthNumber = 0;
        for (index =0; index < year.size(); index++) { 
            char[][] month = year.get(index);
            
            int currentRow = row;
            for (int i = 0; i < month.length; i++) {
                int currentCol = column;
                for (int j = 0; j < month[i].length; j++) {
                    matrix[currentRow][currentCol] = month[i][j];
                    currentCol++;
                }
                currentRow++;
            }
            
            column = column + month[0].length;
            monthNumber++;
            if (monthNumber % numberPerRow == 0) {
                row = row + sizes[bigRow][1];
                column = 0;
                bigRow++;
            }
        }
        return matrix;
    }
    
    private static void printMatrix(char[][] matrix) {
        for (int i =0; i < matrix.length; i++) {
            for (int j = 0; j < matrix[i].length; j++) {
                System.out.print(matrix[i][j]);
            }
            System.out.println();
        }
    }
    
    public static void mainGrigorian(String[] argv) {
        char[][] january  = drawMonth(-1, "Януари",    31, 6, -1);
        char[][] february = drawMonth(-1, "Февруари",  29, 2, -1);
        char[][] march    = drawMonth(-1, "Март",      31, 3, -1);
        char[][] april    = drawMonth(-1, "Април",     30, 6, -1);
        char[][] may      = drawMonth(-1, "Май",       31, 1, -1);
        char[][] june     = drawMonth(-1, "Юни",       30, 4, 22);
        char[][] july     = drawMonth(-1, "Юли",       31, 6, -1);
        char[][] august   = drawMonth(-1, "Август",    31, 2, -1);
        char[][] september= drawMonth(-1, "Септември", 30, 5, -1);
        char[][] october  = drawMonth(-1, "Октомври",  31, 0, -1);
        char[][] november = drawMonth(-1, "Ноември",   30, 3, -1);
        char[][] december = drawMonth(-1, "Декември",  31, 5, -1);
        ArrayList<char[][]> year = new ArrayList<char[][]>(1);
        year.add(january);
        year.add(february);
        year.add(march);
        year.add(april);
        year.add(may);
        year.add(june);
        year.add(july);
        year.add(august);
        year.add(september);
        year.add(october);
        year.add(november);
        year.add(december);
        
        char[][] matrix = drawYear(year);
        printMatrix(matrix);
    }
    
    public static void mainBulgarian(String[] argv) {
        char[][] january  = drawMonth(-1, "Първи",      31, 6, -1);
        char[][] february = drawMonth(-1, "Втори",      30, 2, -1);
        char[][] march    = drawMonth(-1, "Трети",      30, 3, -1);
        char[][] april    = drawMonth(-1, "Четвърти",   31, 6, -1);
        char[][] may      = drawMonth(-1, "Пети",       30, 1, -1);
        char[][] june     = drawMonth(-1, "Шести",      30, 4, 22);
        char[][] eni      = drawMonth(-1, "Ени-Джитем", 1,  1, -1);
        char[][] july     = drawMonth(-1, "Седми",      31, 6, -1);
        char[][] august   = drawMonth(-1, "Осми",       30, 2, -1);
        char[][] september= drawMonth(-1, "Девети",     30, 5, -1);
        char[][] october  = drawMonth(-1, "Десети",     31, 0, -1);
        char[][] november = drawMonth(-1, "Единайсти",  30, 3, -1);
        char[][] december = drawMonth(-1, "Дванайсти",  30, 5, -1);
        char[][] ani      = drawMonth(-1, "Ани-Алем",   1,  1, -1);
        ArrayList<char[][]> year = new ArrayList<char[][]>(1);
        year.add(january);
        year.add(february);
        year.add(march);
        year.add(april);
        year.add(may);
        year.add(june);
        year.add(eni);
        year.add(july);
        year.add(august);
        year.add(september);
        year.add(october);
        year.add(november);
        year.add(december);
        year.add(ani);
        
        char[][] matrix = drawYear(year);
        printMatrix(matrix);
    }
    
    public static void main(String[] argv) throws Exception {
        
        
        //Locale locale = Locale.FRENCH;
        Locale locale = new Locale("bg");
//        LetoBase l = new LetoBulgarian();
        LetoBase l = new LetoBulgarian();
        LetoPeriod[] periods = l.getToday();
        if (periods == null || periods.length < 3) {
            throw new Exception("Insufficient periods supported by calendar. No visuatiozation is possible.");
        }
        LetoPeriod day = periods[0];
        LetoPeriod month = periods[1];
        LetoPeriod year = periods[2];
        
        long d = year.startsAtDaysAfterEpoch();
        int weekday = (int) ((d )% 7);
        
        
        
        System.out.println("   " + (year.getAbsoluteNumber() + 1) + " " + year.getType().getName());
        LetoPeriodStructure structure = year.getStructure();
        LetoPeriodStructure[] months = structure.getSubPeriods();
        
        ArrayList<char[][]> yearDraw = new ArrayList<char[][]>(1);

        for (int i =0 ; i < months.length; i++) {
            int currentDay = -1;
            if (month.getNumber() == i) {
                currentDay = ((int)day.getNumber()) + 1;
            }
            char[][] monthDraw = drawMonth(-1, months[i].getName(locale),  (int)months[i].getTotalLengthInDays(), 
                            weekday, currentDay);
            yearDraw.add(monthDraw);
            weekday = weekday + (int)months[i].getTotalLengthInDays();
            weekday = weekday % 7;
        }
        char[][] matrix = drawYear(yearDraw);
        printMatrix(matrix);

    }

}
