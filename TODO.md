# TODO List

- Box view / route (home)
- Move Pokedex view as non-home route (hidden)
- Add menu buttons (boxes, pokedex) -> hidden
- Convert sprites to spritesheet
  - Add pokesprite images?
- Pokemon details view (modal, responsive)
  - Dex num, Name, Types, Abilities, Forms, Base Stats (chart), Yield Evs, etc.
- Add redux actions to save stored Pokemon to localStorage
  - Mark
  - Select all/none
  - Save
- LocalStorage export/import (json)

## LivingDex Wave 1: Current UI Replacement
- Remove the fixed Footer, make the vertical layout a normal display block. 
Clicking will open the detail of the pokemon and that's it. 
Hovering too quickly and changing footer data so quickly is not a good UX anyway.
	
- Add router to change the page with the hash
- Add about page / github icon in the menu
- Use API-like routes for the json data files (change in lvd-data)
- Generate a spritesheet of home renders to save requests and bandwidth
    - actually 2: one for normal sprites and another one for shiny
- Add a Boxes view, using CSS grids
- Polish UI
    - Fix the footer on iPhone
    - Add icons to the menu or remove it
- Pokemon details view with basic info: Name, Types, Abilities, Stats, Forms, Link to websites, etc.
- View Shiny (reveal, view all)
- Add the essential icons
- Cleanup code & move to main repo
- Publish & announce


## LivingDex Wave 2
- If data structure is stable, take the assets from pokemon-assets instead of livingdex-data
	livingdex-data -> pokemon-assets -> livingdex-redux

- Box Interactions (Redux State, Local Storage):
    - Mark as captured
    - Include/Exclude certain categories :
        - Filtering and Sorting
    
- Pokedex Filtering and Sorting
- Extended Details:
    - Learnset (gen 8)
    - Game appearances
    - All stats
    - Evolution Chain
    - Form Changes Diagram


## LivingDex Wave 3+++

- Bring abilities, items and moves data on board to show their detailed info
- Trainer Card creator
- Badges Collector (all gens)
- Per-game Pokedex tracker (Kalos, Alola, etc.)
- Team Builder (koffing parser) & Advanced Box Management
  - Build and share rental teams with your own in-game code
  - Edit your boxes pokemon to add detailed info (evs, ivs, moves, etc.)
  - Save team presets from the pokemon in your boxes
  - Rearrange your boxes manually
  - Team weakeness calculator
  - Suggest Showdown sets (using showdown-data)  
- Tier Creator (S, A, B, C, D ; top 10; etc.)
- Pokemon GO Stats
- Pokemon GO CP Calculator
