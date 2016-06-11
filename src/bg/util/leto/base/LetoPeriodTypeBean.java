package bg.util.leto.base;

import bg.util.leto.api.LetoExceptionUnrecoverable;
import bg.util.leto.api.LetoPeriodStructure;

public class LetoPeriodTypeBean extends LetoPeriodTypeBase {

    private String mName = null;
    
    private String mDescription = null;
    
    private LetoPeriodStructure[] mPossibleStructures = null;
    
    public LetoPeriodTypeBean(String name, String description, LetoPeriodStructure[] structures) 
    throws LetoExceptionUnrecoverable
    {
        setName(name);
        setDescription(description);
        setPossibleStructures(structures);
        if (structures != null) {
            for (int i = 0; i < structures.length; i++) {
                structures[i].setPeriodType(this);             // Can throw LetoException 
            }
        }
    }

    public void setDescription(String description) {
        mDescription = description;
    }
    
    @Override
    public String getDescription() {
        return mDescription;
    }

    public void setName(String name) {
        mName = name;
    }
    
    @Override
    public String getName() {
        return mName;
    }

    public void setPossibleStructures(LetoPeriodStructure[] structures) {
        mPossibleStructures = structures;
    }
    
    @Override
    public LetoPeriodStructure[] getPossibleStructures() {
        return mPossibleStructures;
    }
    
    @Override
    public String toString() {
        return getName();
    }

}
