package com.example.tests;

import java.util.regex.Pattern;
import java.util.concurrent.TimeUnit;
import org.junit.*;
import static org.junit.Assert.*;
import static org.hamcrest.CoreMatchers.*;
import org.openqa.selenium.*;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;

public class TestJava {
  private WebDriver driver;
  private String baseUrl;
  private boolean acceptNextAlert = true;
  private StringBuffer verificationErrors = new StringBuffer();

  @Before
  public void setUp() throws Exception {
    driver = new FirefoxDriver();
    baseUrl = "https://www.google.com.ua/";
    driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
  }

  @Test
  public void testJava() throws Exception {
<?php
class Example extends PHPUnit_Extensions_SeleniumTestCase
{
  protected function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("https://www.google.com.ua/");
  }

  public function testMyTestCase()
  {
package com.example.tests;

import java.util.regex.Pattern;
import java.util.concurrent.TimeUnit;
import org.junit.*;
import static org.junit.Assert.*;
import static org.hamcrest.CoreMatchers.*;
import org.openqa.selenium.*;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;

public class ScheduleTest {
  private WebDriver driver;
  private String baseUrl;
  private boolean acceptNextAlert = true;
  private StringBuffer verificationErrors = new StringBuffer();

  @Before
  public void setUp() throws Exception {
    driver = new FirefoxDriver();
    baseUrl = "http://tt.smiss.ua";
    driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
  }

  @Test
  public void testUntitled() throws Exception {
    driver.get(baseUrl + "/tracking/index.php?r=site/login");
	this.logIn();
	String[] arr = {"Admin"}; //, "Manager", "User",};
    
	for(String str : arr)
	{
		//this.createUser(str);
		this.fullTest(str);
	}
    
  }
  
  public void logIn()
  {
	    driver.findElement(By.id("LoginForm_username")).clear();
	    driver.findElement(By.id("LoginForm_username")).sendKeys("adm");
	    driver.findElement(By.id("LoginForm_password")).clear();
	    driver.findElement(By.id("LoginForm_password")).sendKeys("1111");
	    driver.findElement(By.id("LoginForm_rememberMe")).click();
	    driver.findElement(By.name("yt0")).click();
  }

  public void createUser(String str)
  {
	    driver.findElement(By.linkText("Управление пользователями")).click();
	    driver.findElement(By.linkText("Create User")).click();
	    driver.findElement(By.id("User_login")).clear();
	    driver.findElement(By.id("User_login")).sendKeys("selenium_" + str);
	    driver.findElement(By.id("User_password")).clear();
	    driver.findElement(By.id("User_password")).sendKeys("1111");
	    driver.findElement(By.id("User_name")).clear();
	    driver.findElement(By.id("User_name")).sendKeys("selenium_" + str);
	    driver.findElement(By.id("User_email")).clear();
	    driver.findElement(By.id("User_email")).sendKeys("selenium_" + str + "@gmail.com");
	    new Select(driver.findElement(By.id("type"))).selectByVisibleText(str);
	    new Select(driver.findElement(By.id("User_jira_id"))).selectByVisibleText("1111117");
	    driver.findElement(By.id("User_jira_user")).clear();
	    driver.findElement(By.id("User_jira_user")).sendKeys("maxim");
	    driver.findElement(By.name("yt0")).click();  
  }
  
  public void checkCurrentScheduleSettings()
  {
	  
  }
  
  public void fullTest(String str)
  {
	    String name = "selenium_" + str;
	    driver.findElement(By.linkText("График")).click();
	    
	    new Select(driver.findElement(By.id("ym"))).selectByVisibleText("Default");
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText("Все");
	    driver.findElement(By.name("yt0")).click();
	    new Select(driver.findElement(By.id("ym"))).selectByVisibleText("Май 2014");
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText(name);
	    
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    try {
	      assertEquals("09:00", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    new Select(driver.findElement(By.id("ym"))).selectByVisibleText("Default");
	    driver.findElement(By.id("def_from")).clear();
	    driver.findElement(By.id("def_from")).sendKeys("09:01");
	    driver.findElement(By.id("def_to")).clear();
	    driver.findElement(By.id("def_to")).sendKeys("09:01");
	    driver.findElement(By.name("yt0")).click();
	    new Select(driver.findElement(By.id("ym"))).selectByVisibleText("Май 2014");
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    try {
	      assertEquals("09:01", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText("Все");
	    driver.findElement(By.id("def_from")).clear();
	    driver.findElement(By.id("def_from")).sendKeys("09:02");
	    driver.findElement(By.id("def_to")).clear();
	    driver.findElement(By.id("def_to")).sendKeys("09:02");
	    driver.findElement(By.name("yt0")).click();
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText(name);
	    driver.findElement(By.xpath("//table[@id='calendar']/tbody/tr[2]/td[2]/span")).click();
	    try {
	      assertEquals("09:02", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    driver.findElement(By.id("def_from")).clear();
	    driver.findElement(By.id("def_from")).sendKeys("09:03");
	    driver.findElement(By.id("def_to")).clear();
	    driver.findElement(By.id("def_to")).sendKeys("09:03");
	    driver.findElement(By.name("yt0")).click();
	    driver.findElement(By.xpath("//table[@id='calendar']/tbody/tr[2]/td/span")).click();
	    try {
	      assertEquals("09:03", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    new Select(driver.findElement(By.id("ym"))).selectByVisibleText("Default");
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText("Все");
	    driver.findElement(By.id("from_1")).clear();
	    driver.findElement(By.id("from_1")).sendKeys("09:04");
	    driver.findElement(By.id("to_1")).clear();
	    driver.findElement(By.id("to_1")).sendKeys("09:04");
	    
	    if(!driver.findElement(By.id("active_1")).isSelected())
	    	driver.findElement(By.id("active_1")).click();
	    
	    driver.findElement(By.name("yt0")).click();
	    new Select(driver.findElement(By.id("ym"))).selectByVisibleText("Май 2014");
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText(name);
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    try {
	      assertEquals("09:04", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    new Select(driver.findElement(By.id("ym"))).selectByVisibleText("Default");
	    driver.findElement(By.id("from_1")).clear();
	    driver.findElement(By.id("from_1")).sendKeys("09:05");
	    driver.findElement(By.id("to_1")).clear();
	    driver.findElement(By.id("to_1")).sendKeys("09:05");
	    
	    if(!driver.findElement(By.id("active_1")).isSelected())
	    	driver.findElement(By.id("active_1")).click();
	    
	    driver.findElement(By.name("yt0")).click();
	    new Select(driver.findElement(By.id("ym"))).selectByVisibleText("Май 2014");
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    try {
	      assertEquals("09:05", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText("Все");
	    driver.findElement(By.id("from_1")).clear();
	    driver.findElement(By.id("from_1")).sendKeys("09:06");
	    driver.findElement(By.id("to_1")).clear();
	    driver.findElement(By.id("to_1")).sendKeys("09:06");
	    
	    if(!driver.findElement(By.id("active_1")).isSelected())
	    	driver.findElement(By.id("active_1")).click();
	    
	    driver.findElement(By.name("yt0")).click();
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText(name);
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    try {
	      assertEquals("09:06", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    driver.findElement(By.id("from_1")).clear();
	    driver.findElement(By.id("from_1")).sendKeys("09:07");
	    driver.findElement(By.id("to_1")).clear();
	    driver.findElement(By.id("to_1")).sendKeys("09:07");
	    
	    if(!driver.findElement(By.id("active_1")).isSelected())
	    	driver.findElement(By.id("active_1")).click();
	    
	    driver.findElement(By.name("yt0")).click();
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    try {
	      assertEquals("09:07", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText("Все");
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    driver.findElement(By.name("date_start")).clear();
	    driver.findElement(By.name("date_start")).sendKeys("09:08");
	    driver.findElement(By.name("date_stop")).clear();
	    driver.findElement(By.name("date_stop")).sendKeys("09:08");
	    driver.findElement(By.name("save")).click();
	    new Select(driver.findElement(By.id("user"))).selectByVisibleText(name);
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    try {
	      assertEquals("09:08", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    driver.findElement(By.xpath("//table[@id='calendar']/tbody/tr[3]/td/span")).click();
	    try {
	      assertEquals("09:07", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    driver.findElement(By.name("date_start")).clear();
	    driver.findElement(By.name("date_start")).sendKeys("09:09");
	    driver.findElement(By.name("date_stop")).clear();
	    driver.findElement(By.name("date_stop")).sendKeys("09:09");
	    driver.findElement(By.name("save")).click();
	    driver.findElement(By.cssSelector("td.open_popup[data-id='5']")).click();
	    try {
	      assertEquals("09:09", driver.findElement(By.name("date_start")).getAttribute("value"));
	    } catch (Error e) {
	      verificationErrors.append(e.toString());
	    }
	    driver.findElement(By.cssSelector("span.close")).click();	  
	  
  }
  
  @After
  public void tearDown() throws Exception {
    driver.quit();
    String verificationErrorString = verificationErrors.toString();
    if (!"".equals(verificationErrorString)) {
      fail(verificationErrorString);
    }
  }

  private boolean isElementPresent(By by) {
    try {
      driver.findElement(by);
      return true;
    } catch (NoSuchElementException e) {
      return false;
    }
  }

  private boolean isAlertPresent() {
    try {
      driver.switchTo().alert();
      return true;
    } catch (NoAlertPresentException e) {
      return false;
    }
  }

  private String closeAlertAndGetItsText() {
    try {
      Alert alert = driver.switchTo().alert();
      String alertText = alert.getText();
      if (acceptNextAlert) {
        alert.accept();
      } else {
        alert.dismiss();
      }
      return alertText;
    } finally {
      acceptNextAlert = true;
    }
  }
}
  }
}
?>
  }

  @After
  public void tearDown() throws Exception {
    driver.quit();
    String verificationErrorString = verificationErrors.toString();
    if (!"".equals(verificationErrorString)) {
      fail(verificationErrorString);
    }
  }

  private boolean isElementPresent(By by) {
    try {
      driver.findElement(by);
      return true;
    } catch (NoSuchElementException e) {
      return false;
    }
  }

  private boolean isAlertPresent() {
    try {
      driver.switchTo().alert();
      return true;
    } catch (NoAlertPresentException e) {
      return false;
    }
  }

  private String closeAlertAndGetItsText() {
    try {
      Alert alert = driver.switchTo().alert();
      String alertText = alert.getText();
      if (acceptNextAlert) {
        alert.accept();
      } else {
        alert.dismiss();
      }
      return alertText;
    } finally {
      acceptNextAlert = true;
    }
  }
}
