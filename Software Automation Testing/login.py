from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import NoSuchElementException, TimeoutException
import time

def test_openlibrary():
    options = webdriver.ChromeOptions()
    options.add_argument("--start-maximized")
    driver = webdriver.Chrome(options=options)
    
    try:
        print("1. Loading OpenLibrary...")
        driver.get("https://openlibrary.org/")
        
        WebDriverWait(driver, 15).until(
            EC.title_contains("Open Library"))
        print("✓ Homepage loaded successfully")

        print("\n2. Going to login page...")
        try:
            login_link = WebDriverWait(driver, 15).until(
                EC.element_to_be_clickable((By.CSS_SELECTOR, "a[href='/account/login']")))
            login_link.click()
        except TimeoutException:
            login_link = WebDriverWait(driver, 15).until(
                EC.element_to_be_clickable((By.LINK_TEXT, "Log in")))
            login_link.click()

        print("\n3. Logging in...")
        username = "saiaunglin17@gmail.com"
        password = "Saiaunglin2005"
        
        WebDriverWait(driver, 15).until(
            EC.visibility_of_element_located((By.ID, "username"))).send_keys(username)
        driver.find_element(By.ID, "password").send_keys(password)
        
        submit_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "button[type='submit']")))
        submit_button.click()

        print("\n4. Verifying login...")
        try:
            WebDriverWait(driver, 15).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, "a[href*='/people/']")))
            print("✓ Logged in successfully")
        except TimeoutException:
            error_msg = driver.find_elements(By.CSS_SELECTOR, ".alert-danger")
            if error_msg:
                print(f"! Login failed: {error_msg[0].text}")
            else:
                print("! Login verification failed - unknown error")
            raise

    finally:
        time.sleep(5)
        driver.quit()

if __name__ == "__main__":
    test_openlibrary()

    