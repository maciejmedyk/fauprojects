/*
package FNC_agora;

import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;
import static org.junit.Assert.*;

*/
/**
 * Tests Product Functions
 *
 * @author Maciej Medyk and Caio Farias
 *//*

public class ProductTest {

    public ProductTest() {
    }

    @BeforeClass
    public static void setUpClass() {
    }

    @AfterClass
    public static void tearDownClass() {
    }

    @Before
    public void setUp() {
    }

    @After
    public void tearDown() {
    }

    */
/**
     * Test of changeProduct method, of class Product.
     *//*

    @Test
    public void testChangeProduct() {
        System.out.println("changeProduct");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(123, name, desc, cat, sp, ip, qty);
        instance.changeProduct(name, desc, cat, sp, ip, qty);
        assertTrue(instance.getProductName().contains(name));
    }

    */
/**
     * Test of getProductName method, of class Product.
     *//*

    @Test
    public void testGetProductName() {
        System.out.println("getProductName");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(123, name, desc, cat, sp, ip, qty);
        String expResult = name;
        String result = instance.getProductName();
        assertEquals(expResult, result);
    }

    */
/**
     * Test of getProductDec method, of class Product.
     *//*

    @Test
    public void testGetProductDec() {
        System.out.println("getProductDec");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(123, name, desc, cat, sp, ip, qty);
        String expResult = desc;
        String result = instance.getProductDec();
        assertEquals(expResult, result);
    }

    */
/**
     * Test of getSellPrice method, of class Product.
     *//*

    @Test
    public void testGetSellPrice() {
        System.out.println("getSellPrice");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(123, name, desc, cat, sp, ip, qty);
        double expResult = sp;
        double result = instance.getSellPrice();
        assertTrue(expResult == result);
    }

    */
/**
     * Test of getCostPrice method, of class Product.
     *//*

    @Test
    public void testGetCostPrice() {
        System.out.println("getCostPrice");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(123, name, desc, cat, sp, ip, qty);
        double expResult = ip;
        double result = instance.getCostPrice();
        assertTrue(expResult == result);
    }

    */
/**
     * Test of getQuantity method, of class Product.
     *//*

    @Test
    public void testGetQuantity() {
        System.out.println("getQuantity");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(123, name, desc, cat, sp, ip, qty);;
        int expResult = qty;
        int result = instance.getQuantity();
        assertEquals(expResult, result);
    }

    */
/**
     * Test of getCategory method, of class Product.
     *//*

    @Test
    public void testGetCategory() {
        System.out.println("getCategory");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(123, name, desc, cat, sp, ip, qty);
        String expResult = cat;
        String result = instance.getCategory();
        assertEquals(expResult, result);
    }

    */
/**
     * Test of setQuantity method, of class Product.
     *//*

    @Test
    public void testSetQuantity() {
        System.out.println("setQuantity");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(123, name, desc, cat, sp, ip, qty);
        int q = 50;
        instance.setQuantity(q);
        assertTrue(instance.getQuantity() == q);
    }

    */
/**
     * Test of getProductID method, of class Product.
     *//*

    @Test
    public void testGetProductID() {
        System.out.println("getProductID");
        int productID = 1234567;
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(productID, name, desc, cat, sp, ip, qty);
        int expResult = productID;
        int result = instance.getProductID();
        assertEquals(expResult, result);
    }

    */
/**
     * Test of getClone method, of class Product.
     *//*

    @Test
    public void testGetClone() {
        System.out.println("getClone");
        String name = "Game of Thrones";
        String desc = "TV series based on Ice and Fire books.";
        String cat = "Movies";
        double sp = 40.0;
        double ip = 20.0;
        int qty = 20;
        Product instance = new Product(123, name, desc, cat, sp, ip, qty);
        Product expResult = new Product(123, name, desc, cat, sp, ip, qty);
        Product result = instance.getClone();
        assertTrue(result.getProductName().equals(expResult.getProductName()));
    }
}
*/
