# Peptide Dosing Calculator (WordPress Plugin)

## Overview
A lightweight, shortcode-based WordPress plugin that provides a peptide reconstitution and dosing calculator using vanilla JavaScript.

Shortcode:
```
[peptide_dosing_calculator]
```

## Features
- OOP-based structure
- Conditional asset loading
- Real-time calculation
- Responsive design
- Syringe capacity warning
- Input validation like set the minimum and maximum value which can be enter in these fields

## Installation
1. Download the ZIP file.
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin.
3. Upload and activate the plugin.
4. Add shortcode `[peptide_dosing_calculator]` to any page or post.

## Calculation Formula
- Concentration (mcg/mL) = (vial_mg × 1000) / water_mL
- Volume per dose (mL) = desired_dose_mcg / concentration
- Units to draw = volume_mL × 100
- Doses per vial = floor((vial_mg × 1000) / desired_dose_mcg)

## Test Cases Verified
1. 10 mg + 2 mL + 500 mcg → 5000 mcg/mL, 0.1 mL, 10 units, 20 doses
2. 5 mg + 1 mL + 250 mcg → 5000 mcg/mL, 0.05 mL, 5 units, 20 doses
3. 10 mg + 1 mL + 2000 mcg → No warning on 1mL syringe
4. 5 mg + 2 mL + 1000 mcg → Warn on 30-unit syringe

## Technical Decisions
- Client-side calculation according to requirement of task
- Vanilla JS according to requirement of task
- Clean, maintainable structure

## Known Limitations
-  Does NOT save data in database
- Does NOT store previous calculations
- Educational tool only (not medical advice)
- Does NOT verify real-world medical correctness

## License
GPL-2.0-or-later

## Reasoning behind this apporach 
- Matches task requirement exactly.
- Keeps the plugin theme-independent.
- Allows flexible placement in posts/pages.
- Avoids modifying templates or requiring Gutenberg blocks.
- Improves code organization and readability.
- Provides real-time feedback without page reload.
- No database or persistence needed.
- Improves user experience.
- Lightweight and backward compatible.


