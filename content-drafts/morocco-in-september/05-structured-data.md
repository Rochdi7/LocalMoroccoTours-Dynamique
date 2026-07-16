# JSON-LD Structured Data

Placeholders use square brackets — replace before publishing. FAQ answers match `01-article.md` exactly.

## 1. BlogPosting / Article

```json
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "Best Places to Visit in Morocco in September",
  "description": "A local's guide to the best places to visit in Morocco in September, covering weather by region, top destinations, itineraries, and practical planning tips.",
  "url": "[ARTICLE_URL]",
  "mainEntityOfPage": "[ARTICLE_URL]",
  "image": "[FEATURED_IMAGE_URL]",
  "datePublished": "[PUBLISH_DATE]",
  "dateModified": "[MODIFIED_DATE]",
  "author": {
    "@type": "Organization",
    "name": "[AUTHOR_NAME]",
    "url": "https://www.authenticmoroccoadventures.com/"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Authentic Morocco Adventures",
    "logo": {
      "@type": "ImageObject",
      "url": "[LOGO_URL]"
    }
  },
  "inLanguage": "en"
}
```

## 2. FAQPage

```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Is September a good month to visit Morocco?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, September is generally a good month to visit Morocco, especially for travelers avoiding peak summer crowds. Early September can still be hot, particularly inland and in the desert, while late September tends to bring more comfortable temperatures across most regions. Coastal areas like Essaouira remain mild throughout the month."
      }
    },
    {
      "@type": "Question",
      "name": "Is Morocco still hot in September?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, especially early in the month. Inland cities like Marrakech and Fes commonly see highs in the low-to-mid 30s°C (86–95°F) in early September, easing somewhat by late month. The Atlantic coast stays considerably cooler throughout, so heat-sensitive travelers can moderate their experience by choosing coastal stops."
      }
    },
    {
      "@type": "Question",
      "name": "Is Marrakech too hot in September?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Not necessarily, but midday heat in early September can be uncomfortable for extended outdoor walking. Mornings and evenings are pleasant throughout the month, and by late September, daytime temperatures become noticeably more manageable. Planning Medina and souk visits around the cooler parts of the day is the practical solution."
      }
    },
    {
      "@type": "Question",
      "name": "Can you visit the Sahara Desert in September?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. September is a viable month for Merzouga and Erg Chebbi, though days remain hot (commonly 30–35°C) while nights are cooler and more comfortable. Camel treks and 4x4 excursions are best scheduled for early morning or late afternoon to avoid the most intense midday heat."
      }
    },
    {
      "@type": "Question",
      "name": "What should I wear in Morocco in September?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Lightweight, breathable clothing for daytime heat, a light layer for cooler evenings, and modest coverage (shoulders and knees) for Medinas and rural areas. Add proper layers for High Atlas trekking and a warmer layer for desert nights, where temperatures drop more than daytime heat suggests."
      }
    },
    {
      "@type": "Question",
      "name": "Is September crowded in Morocco?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "September is less crowded than July and August, Morocco's peak tourist months, but it is not a quiet off-season. Accommodation and desert camps are generally easier to book than in summer, though popular options can still fill up, particularly around local festival periods."
      }
    },
    {
      "@type": "Question",
      "name": "Can you swim in Morocco in September?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, along the Atlantic coast, though water temperatures are cool rather than warm — around 21°C (70°F) near Essaouira. Riad and hotel pools inland offer a warmer alternative, and are a common way to cool off after a hot day in Marrakech or Fes."
      }
    },
    {
      "@type": "Question",
      "name": "Is September good for hiking in the Atlas Mountains?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, September is one of the better months for High Atlas trekking, as summer heat eases and conditions generally stabilize. Daytime temperatures at trekking elevations are typically comfortable, though weather can shift quickly, and by late September isolated snow can appear at the highest elevations."
      }
    },
    {
      "@type": "Question",
      "name": "How many days should I spend in Morocco?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Seven to ten days allows a realistic combination of Marrakech, the kasbah route, and the Sahara Desert without rushing the driving days involved. Five days works for a Marrakech-centered trip with shorter excursions, while two weeks allows an additional northern Morocco leg (Fes, Chefchaouen)."
      }
    },
    {
      "@type": "Question",
      "name": "What is the best Morocco itinerary for September?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The best itinerary depends on available time and heat tolerance, but a 7 to 10-day route combining Marrakech, Aït Benhaddou, the Dades Valley or Todra Gorge, and a Merzouga desert camp covers Morocco's most requested experiences. Adding Essaouira balances the trip with a cooler coastal stop."
      }
    },
    {
      "@type": "Question",
      "name": "Does it rain in Morocco in September?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Rain is possible but generally light and infrequent. Interestingly, September is statistically one of the wetter months in the Moroccan Sahara compared to peak summer, though rainfall there remains uncommon overall. Coastal and inland cities typically see minimal rainfall in September as well."
      }
    },
    {
      "@type": "Question",
      "name": "Should I book a private Morocco tour in advance?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Booking ahead is advisable, particularly for desert camps, popular riads, and any dates overlapping with local festivals. A private tour also simplifies the long driving segments between regions, which is one of the more demanding logistical aspects of a September Morocco itinerary."
      }
    }
  ]
}
```

## 3. BreadcrumbList

```json
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://www.authenticmoroccoadventures.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Blog",
      "item": "https://www.authenticmoroccoadventures.com/blog"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Best Places to Visit in Morocco in September",
      "item": "[ARTICLE_URL]"
    }
  ]
}
```
