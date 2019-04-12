package bg.util.leto.test;

public class Count12Cycles {

    public static String align(String str, int total) {
        int len = 0;
        if (str != null) {
            len = str.length();
        }
        int remaining = total - len;
        if (remaining <= 0 ) {
            remaining = 0;
        }
        StringBuffer sb = new StringBuffer();
        for (int i =0 ; i < remaining; i++) {
            sb.append(" ");
        }
        return str + sb.toString();
    }
    
    
    public static void main(String[] argv) {
        int bgYear = 1;
        int grYear = -5505;
        int starDay = 1;
        
        String[] animalsM = new String[] {"Плъх", "Вол",   "Барс",  "Заек",  "Дракон", "Змий",  "Кон",    "Овен", "Маймун",  "Петел",   "Куче",  "Глиган", };
        String[] animalsF = new String[] {"Мишка", "Крава", "Барса", "Зайка", "Хала",   "Змия",  "Кобила", "Овца", "Маймуна", "Кокошка", "Кучка", "Свиня",  };
        String[] animals = new String[] {"Сомор", "Шегор", "Барс",  "Дванш", "Верени", "Дилом", "Теку именшегор", "Текучитем", "Маймуна", "Тох", "Етх", "Дохс",  };
        String[] colorsM  = new String[] {"Черен", "Червен", "Жълт", "Син", "Бял"};
        String[] colorsF  = new String[] {"Черна", "Червена", "Жълта", "Синя", "Бяла"};
        
        boolean male = true;
        int color = 0;
        String[] anim = animalsM;
        String[] colors = colorsM;
        int cycle12 = 0;
        int cycle60 = 0;
        
        

        
        for (; bgYear < 7520; ) {
            
            if (cycle60 == 0) {
                System.out.println();
            }
            
            
            System.out.print("Година " + align("" + bgYear, 5) + " ");
            System.out.print("(" + (grYear <0 ? -grYear : grYear) + " " + (grYear < 0 ? "пр.н.е." : "") + ") ");
            System.out.print("" + align(colors[color], 7) + " ");
            System.out.print(align(anim[cycle12], 15) + align(" [" + animals[cycle12] + "] ", 15));
            if (cycle60 == 0) {
                System.out.print("Начало на звезден ден " + starDay + " ");
            }
            
            
            System.out.println();
            
            cycle12++;
            cycle12 = cycle12 % 12;
            if (cycle12 == 0) {
                male = !male; 
                anim = male ? animalsM : animalsF;
                colors = male ? colorsM : colorsF;
                color++;
                color = color % 5;
            }
            cycle60++;
            cycle60 = cycle60 % 60;
            if (cycle60 == 0) {
                starDay++;
            }
            bgYear++;
            grYear++;
            if (grYear == 0) {
                grYear++;
            }
        }
        
        
    }
}