/*
package FNC_agora;

import java.util.ArrayList;
import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;
import static org.junit.Assert.*;

*/
/**
 * Tests UserManager functions
 *
 * @author Maciej Medyk and Caio Farias
 *//*

public class UserManagerTest {

    public UserManagerTest() {
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
     * Test of addVendor method, of class UserManager.
     *//*

    @Test
    public void testAddVendor() {
        System.out.println("addVendor");
        String name = "Maciej Medyk";
        String email = "mmedyk@fau.edu";
        String username = "mmedyk";
        String password = "1234";
        String date = "02/17/1980";

        UserManager instance = new UserManager();
        int presize = instance.getVendors().size();
        instance.addVendor(name, email, username, password, date);
        int postsize = instance.getVendors().size();
        assertTrue(presize + 1 == postsize);
        assertTrue(instance.getVendor(instance.getVendors().size() - 1).getFullName().equals(name));
    }

    */
/**
     * Test of addCustomer method, of class UserManager.
     *//*

    @Test
    public void testAddCustomer() {
        System.out.println("addCustomer");
        String name = "Caio Farias";
        String email = "cfarias@fau.edu";
        String username = "cfarias";
        String password = "4321";
        String date = "04/26/1988";
        UserManager instance = new UserManager();
        int presize = instance.getCustomers().size();
        instance.addCustomer(name, email, username, password, date);
        int postsize = instance.getCustomers().size();
        assertTrue(presize + 1 == postsize);
        assertTrue(instance.getCustomer(instance.getCustomers().size() - 1).getFullName().equals(name));
    }

    */
/**
     * Test of getVendors method, of class UserManager.
     *//*

    @Test
    public void testGetVendors() {
        System.out.println("getVendors");
        UserManager instance = new UserManager();
        ArrayList<Vendor> expResult = new ArrayList<Vendor>();
        ArrayList<Vendor> result = instance.getVendors();
        assertEquals(expResult, result);
    }

    */
/**
     * Test of getCustomers method, of class UserManager.
     *//*

    @Test
    public void testGetCustomers() {
        System.out.println("getCustomers");
        UserManager instance = new UserManager();
        ArrayList<Customer> expResult = new ArrayList<Customer>();
        ArrayList<Customer> result = instance.getCustomers();
        assertEquals(expResult, result);
    }

    */
/**
     * Test of getVendor method, of class UserManager.
     *//*

    @Test
    public void testGetVendor() {
        System.out.println("getVendor");
        int i = 0;
        UserManager instance = new UserManager();
        instance.addVendor("name", "email", "username", "password", "date");
        Vendor expResult = new Vendor("name", "email", "username", "password", "date");
        Vendor result = instance.getVendor(i);
        assertEquals(expResult.getFullName(), result.getFullName());
    }

    */
/**
     * Test of getCustomer method, of class UserManager.
     *//*

    @Test
    public void testGetCustomer() {
        System.out.println("getCustomer");
        int i = 0;
        UserManager instance = new UserManager();
        instance.addCustomer("name", "email", "username", "password", "date");
        Customer expResult = new Customer("name", "email", "username", "password", "date");
        Customer result = instance.getCustomer(i);
        assertEquals(expResult.getFullName(), result.getFullName());
    }

    */
/**
     * Test of login method, of class UserManager.
     *//*

    @Test
    public void testLogin() {
        System.out.println("login");
        String username = "mmedyk";
        String password = "1234";
        UserManager instance = new UserManager();
        instance.addVendor("Maciej Medyk", "mmedyk@fau.edu", username, password, "02/17/1980");
        int expResult = 0;
        int result = instance.login(username, password);
        assertEquals(expResult, result);
    }
}
*/
