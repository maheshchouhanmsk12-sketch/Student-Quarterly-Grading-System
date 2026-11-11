# Student Quarterly Grading System (SQGS)

A web-based School and Student Quarterly Grading Management System built with PHP, MySQL, Bootstrap 5, jQuery, DataTables, and Select2.

[![Deploy to Render](https://render.com/images/deploy-to-render-button.svg)](https://render.com/deploy?repo=https://github.com/maheshchouhanmsk12-sketch/Student-Quarterly-Grading-System)

---

## 🚀 Live Cloud Deployment Guide (Render + Aiven)

### 1. Database Setup on Aiven (Free MySQL)
1. Go to [aiven.io](https://aiven.io/) and create a free account.
2. Click **Create Service** -> Select **MySQL** -> Choose Free Plan.
3. Copy the **Service URI** from your Aiven dashboard:
   ```
   mysql://avnadmin:<PASSWORD>@<HOST>:<PORT>/defaultdb?ssl-mode=REQUIRED
   ```
4. Import the database schema and sample data:
   - Run the local import script:
     ```bash
     python import_db.py --uri "YOUR_AIVEN_SERVICE_URI"
     ```
   - Or run the SQL queries from `database/sqgs_db.sql` directly inside Aiven's console.

---

### 2. Web Deployment on Render
1. Click the **[Deploy to Render](https://render.com/deploy?repo=https://github.com/maheshchouhanmsk12-sketch/Student-Quarterly-Grading-System)** button above.
2. In the **Environment Variables** section, set:
   - **`DATABASE_URL`**: Paste your full Aiven Service URI:
     `mysql://avnadmin:<PASSWORD>@<HOST>:<PORT>/defaultdb?ssl-mode=REQUIRED`
3. Click **Apply / Deploy**.
4. Once Render completes building the Docker container, your app will be live at:
   `https://<your-service-name>.onrender.com`

---

## 🔑 Default Admin Credentials

- **Username:** `admin`
- **Password:** `admin123`
