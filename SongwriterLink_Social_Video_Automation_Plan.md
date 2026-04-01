# SongwriterLink — AI Social Video Automation Plan

**Goal:** Automatically generate short AI avatar videos from approved user lyrics and post them to TikTok and Instagram Reels as promotional content for SongwriterLink.com.

---

## Overview

The pipeline has four stages: **fetch approved lyrics → generate AI avatar video → review → post to social media.** Each stage can be automated, with an optional human review step before anything goes live.

---

## Stage 1 — Fetch Approved Lyrics from Your Database

Your backend already has a permission flag (the tick box on user profiles). The automation queries for lyrics where `social_media_permission = true`, then selects a short, punchy snippet — ideally 4–8 lines that stand alone well.

**What your API endpoint should return:**

- Lyricist display name (or "Anonymous" if they prefer)
- Title of the work (optional)
- Approved snippet (pre-selected or auto-trimmed to ~100 words)
- Genre tag (helps with avatar/music bed selection)

**Tip:** Keep snippets under 60 seconds of speaking time for TikTok/Reels. A good rule of thumb is 100–130 words = ~45 seconds.

---

## Stage 2 — Generate the AI Avatar Video

### Recommended Tool: HeyGen API

[HeyGen](https://www.heygen.com/) is the strongest choice for a programmatic, scalable workflow. It offers:

- **700+ AI avatars** — pick one consistent avatar as the "face of SongwriterLink" for brand consistency
- A **proper REST API** designed for automation (not just a web UI)
- Auto-generated captions that display the lyrics as they're spoken
- Vertical 9:16 output — ready for TikTok and Reels with no re-editing
- Realistic voices with natural pacing — important for poetry/lyrics

**Alternative: Revid.ai** — specifically built for lyrics and music video style content, with built-in lyric animation. Worth testing if you want a more "music video" aesthetic rather than a presenter-style delivery.

### What the API call does:

1. You send the lyrics snippet as the script
2. Specify the avatar, voice, and background
3. HeyGen renders the video (typically under 2 minutes)
4. You receive a downloadable MP4

### Branding suggestions:

- Use a consistent avatar across all posts so viewers start to recognise the "SongwriterLink voice"
- Add a short intro card: *"Today's lyric from SongwriterLink.com"*
- Add an outro card with your URL and a call to action: *"Find this lyric and thousands more at songwriterlink.com"*
- Overlay the lyricist's name as a credit

---

## Stage 3 — Optional Human Review (Strongly Recommended)

Before anything posts publicly, it's worth having a quick review step, at least initially. A few reasons:

- Some lyrics may be powerful but contextually sensitive
- You want to check the AI read the text naturally (it occasionally mispronounces unusual words or names)
- You can catch anything that might violate platform content policies

**How to implement this:** HeyGen can deliver the video to a private review folder or URL. You (or a team member) approve it in a simple dashboard before it moves to Stage 4. Once you trust the pipeline, you can switch to fully automated for most content.

---

## Stage 4 — Post to TikTok and Instagram

### TikTok: Content Posting API

TikTok has an official [Content Posting API](https://developers.tiktok.com/products/content-posting-api/) for programmatic video uploads. Key points:

- Requires a **TikTok developer account** and app approval (review takes 5–10 business days)
- Supports **Direct Post** (goes live immediately) or **Upload to Inbox** (queues as a draft for manual publish)
- Start with "Upload to Inbox" — you review the draft in TikTok before it goes live, which is a good safety net
- You'll need to authenticate with OAuth on behalf of your TikTok business account

### Instagram: Graph API (Reels)

The [Instagram Graph API](https://developers.facebook.com/docs/instagram-api/) supports Reels uploads for business accounts:

- Requires a **Meta developer account** and an Instagram Business account
- You upload the video, set the caption, and publish in two API calls
- Captions should include: lyric credit, genre hashtags, and your URL

### Caption template:

```
✍️ [Lyricist Name] | [Genre]

"[First line of the snippet]..."

🔗 Full lyric available on SongwriterLink.com
Want your lyrics featured? Sign up at songwriterlink.com

#lyrics #lyricist #songwriting #[genre] #SongwriterLink #poetry #indiemusic
```

---

## Putting It All Together — The Automation Workflow

The cleanest way to connect these stages is with **n8n** (open source, self-hostable) or **Make.com** (easier to set up, cloud-based). Both let you build visual workflows without writing much code.

**A typical automated run would look like this:**

1. **Trigger:** Runs on a schedule (e.g. daily at 9am) or manually
2. **Fetch:** Calls your SongwriterLink API to get one approved lyric snippet
3. **Generate:** Sends the snippet to HeyGen API, waits for the video URL
4. **Review step** *(optional)*: Posts a Slack/email notification with a preview link for approval
5. **Post:** On approval (or automatically), uploads the MP4 to TikTok and Instagram via their respective APIs
6. **Log:** Records which lyric was used, the post URLs, and timestamps back to your database (so the same lyric isn't reused)

---

## AI-Generated Content Disclosure

Both TikTok and Instagram now require disclosure when AI tools are used to generate content. TikTok has a built-in "AI-generated content" label you apply at upload time. Instagram has a similar toggle. **Always enable these** — it protects you legally and builds trust with your audience.

---

## Cost Estimate

| Service | Pricing (approximate) |
|---|---|
| HeyGen API | From ~$29/month (hobby) up to usage-based for scale |
| n8n (self-hosted) | Free (server costs only) |
| Make.com | Free tier covers low volume; ~$9/month for more runs |
| TikTok Content Posting API | Free (requires approved developer account) |
| Instagram Graph API | Free |

For posting once a day, you'd be well within the free/low tiers of most services. The main cost is HeyGen for video generation.

---

## Recommended Starting Point

1. **Week 1:** Apply for TikTok developer access and set up a Meta developer account (these take time to approve — start now)
2. **Week 1:** Sign up for HeyGen, pick your avatar, and manually test a few videos using their web UI to validate the format
3. **Week 2:** Build a simple script (Python or n8n) that calls your API, generates a video, and saves it locally
4. **Week 3:** Add the TikTok and Instagram posting steps, using "draft/inbox" mode initially
5. **Week 4:** Enable auto-posting once you're happy with quality and consistency

---

## Legal Checklist

- ✅ You have explicit permission via the tick box on user profiles
- ✅ Credit the lyricist by name in every post
- ✅ Disclose AI-generated content on both platforms
- ⬜ Add a clause to your Terms of Service clarifying how approved content may be used in promotion
- ⬜ Give users a way to withdraw consent and request removal of past posts

---

*Plan prepared for SongwriterLink.com — March 2026*
