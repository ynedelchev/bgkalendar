package bg.util.leto.base;

import bg.util.leto.api.LetoPeriodType;
import bg.util.leto.api.LetoPeriodStructure;

public abstract class LetoPeriodTypeBase implements LetoPeriodType {
    
    @Override
    public abstract String getDescription();

    @Override
    public abstract String getName();

    @Override
    public abstract LetoPeriodStructure[] getPossibleStructures();


}
