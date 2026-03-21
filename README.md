# I-Want-My-MTV 📺
Remember when MTV actually played music? This project is a tribute to the golden era of cable TV. It’s a PHP-based engine designed to recreate the full 90s broadcast experience right in your browser.

This isn't just a video player - it’s a time machine. I built this to bring back that specific, gritty, analog "feeling" of channel surfing in 1995.

<b>What it does</b>
* The engine recreates the iconic MTV on-air look from the 90s. You provide the media, and the app handles the rest:

* Custom Library: You import your own music videos, vintage commercials, and those legendary station idents.

* The "Vibe" Engine: It overlays the classic MTV logos, song title cards (lower thirds), and transitions exactly how they looked back in the day.

* PHP Powered: A lightweight backend to manage your assets and generate a seamless "broadcast" flow.

* Authentic Feel: Randomly injected idents and promos between videos so it never feels like a sterile playlist.

Why?

Because modern streaming is too organized. I wanted the chaos of 90s television - where you didn't know what video was coming next, and the graphics were just as cool as the music.

## 📡 Setup Guide
Follow these steps to get your 90s MTV broadcast up and running:

1. **Download the Project**
   * Go to the **Releases** tab on this GitHub repository.
   * Download the latest version of the source code (ZIP or Tarball).

2. **Install Required Software**
   * **XAMPP:** Download and install from [apachefriends.org](https://www.apachefriends.org/).
   * **OBS Studio:** Download and install from [obsproject.com](https://obsproject.com/).

3. **Configure the Retro 4:3 Look (OBS Studio)**
   * Open **OBS Studio**.
   * Go to **Settings** -> **Video**.
   * Set both **Base (Canvas) Resolution** and **Output (Scaled) Resolution** to `1440x1080`.
   * This ensures your stream has that authentic 4:3 CRT television aspect ratio. Click **OK**.

4. **Prepare the Web Server (XAMPP)**
   * Open the **XAMPP Control Panel**.
   * Click the **Explorer** button on the right side.
   * Navigate to the `htdocs` folder and **delete its entire content**.
   * Unpack the downloaded project files directly into this `htdocs` folder.

5. **Launch the Server**
   * In the **XAMPP Control Panel**, find the **Apache** module and click **Start**.
   * Once it's running, click the **Admin** button next to it.
   * In your browser, open `mtv.php` and **copy the full URL** (e.g., `http://localhost/mtv.php`).

6. **Connect to OBS**
   * In **OBS Studio**, go to the **Sources** dock, click **+** and select **Browser**.
   * Name it "MTV Engine" and click **OK**.
   * Paste the copied URL into the **URL** field.
   * Set **Width** to `1440` and **Height** to `1080`.
   * Click **OK**, and you are ready to go!

## 📂 How to Add Your Own Media

To make the engine work, you need to provide your own video files. After unpacking the project into the `htdocs` folder, you will find two main directories:

1. **`mv` folder** (Music Videos)
   * This is where you put your favorite 90s music videos.
   * **Format:** Use `.mp4` files for the best compatibility.

2. **`idents` folder** (Station Identifiers & Commercials)
   * This is for the "short" clips: classic MTV logos, station idents, and vintage 90s commercials.
   * The engine will automatically shuffle these between your music videos to create that authentic broadcast flow.

**Note:** For the best visual experience, make sure your videos are in **4:3 aspect ratio**. If they are widescreen, you might see black bars, which (let’s be honest) wasn't the 90s vibe!

## 🎨 Bonus: Customization

Want to change the look of the on-screen graphics? You don't need to touch the code. You can easily modify the announcement bars (lower thirds) using the `colors.txt` file.

* **Custom Colors:** Open `colors.txt` in your favorite text editor.
* **How it works:** Simply declare your preferred RGB codes there.
* **Variety:** The engine will use these values to generate the colored bars for song titles and upcoming video announcements, keeping the broadcast fresh and colorful - just like the original MTV.

## 📸 Preview
<img width="1916" height="1438" alt="mtv" src="https://github.com/user-attachments/assets/fbb12f1f-643d-4737-8064-b2e63b8d1bed" />
---

## ⚠️ Legal Disclaimer & Copyright

This project is a non-profit, fan-made tribute to MTV and is intended for educational and nostalgic purposes only. 

* **Music & Media Content:** The included video by **Depeche Mode** is for demonstration purposes only. All rights to the music, video, and branding belong to the respective artists and their record labels. 
* **MTV Branding:** All MTV logos, idents, and trademarks are the property of **Paramount Global** (formerly ViacomCBS).
* **Usage:** I do not claim ownership of any copyrighted material included in the `/mv` or `/idents` folders. If you are the copyright holder and wish for this content to be removed, please contact me.

Please support the artists by purchasing their music and streaming their official content.
