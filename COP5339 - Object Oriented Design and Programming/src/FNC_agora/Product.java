package FNC_agora;

import GUI_agora.Agora;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.Random;

/**
 * Product class that creates object product
 *
 * @author Maciej Medyk and Caio Farias
 */
public class Product implements Serializable, Cloneable
{
    /**
     * Product constructor that creates 
     *
     * @param pId product id
     * @param name name of the customer
     * @param desc product description
     * @param cat product category
     * @param sp sell price
     * @param ip invoice price
     * @param qty product quantity
     */
    public Product(int pId, String name, String desc, String cat, double sp, double ip, int qty)
    {
        mProductID = pId;
        mProductName = name;
        mProductDesc = desc;
        mCategory = cat;
        mSellPrice = sp;
        mInvoicePrice = ip;
        mQuantity = qty;
    }

    /**
     * Updates the product
     *
     * @param name product id
     * @param desc product description
     * @param cat product category
     * @param sp sell price
     * @param ip invoice price
     * @param qty  product quantity
     */
    public void changeProduct(String name, String desc, String cat, double sp, double ip, int qty)
    {
        mProductName = name;
        mProductDesc = desc;
        mCategory = cat;
        mSellPrice = sp;
        mInvoicePrice = ip;
        mQuantity = qty;
    }

    /**
     * Returns product name
     *
     * @return product name string
     */
    public String getProductName()
    {
        return mProductName;
    }

    /**
     * Returns product description
     *
     * @return product desc string
     */
    public String getProductDec()
    {
        return mProductDesc;
    }

    /**
     * Returns sell price
     *
     * @return sell price double
     */
    public double getSellPrice()
    {
        return mSellPrice;
    }

    /**
     * Returns cost price
     *
     * @return cost price double
     */
    public double getCostPrice()
    {
        return mInvoicePrice;
    }

    /**
     * Returns quantity
     *
     * @return product quantity integer
     */
    public int getQuantity()
    {
        return mQuantity;
    }

    /**
     * Returns product category
     *
     * @return category string
     */
    public String getCategory()
    {
        return mCategory;
    }

    /**
     * Sets quantity
     *
     * @param q quantity integer
     */
    public void setQuantity(int q)
    {
        mQuantity = q;
    }

    /**
     * Returns product id
     *
     * @return product id integer
     */
    public int getProductID()
    {
        return mProductID;
    }

    /**
     * Clones product
     *
     * @return product clone
     */
    public Product getClone()
    {
        Product p = this;
        Product z = new Product(p.mProductID, p.mProductName, p.mProductDesc, p.mCategory, p.mSellPrice, p.mInvoicePrice, p.mQuantity);
        return z;

    }

    private int mProductID;
    private String mProductName;
    private String mProductDesc;
    private String mCategory;
    private double mSellPrice;
    private double mInvoicePrice;
    private int mQuantity;
}
