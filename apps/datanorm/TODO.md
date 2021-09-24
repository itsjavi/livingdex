# TODO

- ✅ Export Games and Game Groups
- Calc base stats, weight, height percentiles (PercentileRankCalculator)
- Export Abilities
- Add moves  
- Export Moves
- Add GO moves
- Export GO Moves
- Add items
- Export Items  
- Create a command to add datum by Gen
- Create a command to add Pokemon GO datum
- Add forms (chain) to the forms table
- Export forms (chain) to the json (changesFrom)
- Add evolutions data to table (evolveFrom, evolveWith...)
- Export evolutions data (in Pokemon entry json)
- Add learnsets
- Export learnsets
- Add wild items per gen
- Export wild items
- Add per-game-group availability
- Export game availability
- Add constants table (id, slug, name, category, gen, order) 
   for types, natures, egg-groups, colors, etc
- Export constants table
- Add i18n texts for everything
- Export texts (separated by lang folder e.g. `/i18n/en/pokemon/bulbasaur.json`)


## More

- ✅ Add base_data_pokemon_id
- ✅ Will be used to tell which pokemon record is the base one for
    getting the data. If it's null, means that it has data, if its not
    null means that the data needs to be gotten from the baseDataForm.
    Useful to not duplicate data entries for cosmetic forms.
- Export the rest of entities for livingdex. Make it compatible with
  pokemon-assets API urls.
    - abilities, natures, types, egg groups, etc.
    - translations folder system
    - generations folder system

- ✅ Lightweighter version of livingdex.json (pokemon.json) +
  per-pokemon json files.

- ✅ Define an API-like export structure:
    - /generations/8
      - /pokedexes/national.json
      - /pokemon/bulbasaur.json, /pokemon/bulbasaur-f.json, etc.
      - /pokemon/moves/bulbasaur.json, etc.
      - /abilities.json
      - /moves.json

- ✅ Fix legendary/mythical flags (if base species is l or m)
- Add missing data for non-veekun available data (from bulbapedia)
- MAYBE reorganize pokemon.json extradata into:
    - pokemon.js list of slugs
    - pokemon/SLUG.js as separate files
    - create better data reader class
    - same for moves,items, etc.
  
(will need to see how it works with maintainance scripts)



## Finish normalizers:

- Ability
  - Text
- Move
  - Base
  - Data (entry for every gen if existed)
  - GO Data (add elite flags)
  - Text
- Item
  - Base
  - Text
- Pokemon
  - Base
  - Data (entry for every gen if existed)
  - Forms
  - Evolutions
  - GO Data (add candy costs)
  - Game (availability)
  - Item (wild)
  - Move (learnset)
  - Text (genus, name)
  

## Maybe:

- Pokemon Dex Entries (lang, game, poke)
- Game Text
- Game Group Text
- Move advanced data (flags, etc)
  
## Future Possible Apps:

- livingdex.gg domain
- Team builder (Showdown-compatible)
- User Profiles (dex status sharing)
- Trainer Badges across all games
- Trainer banner & QR, etc.  
- Pokemon GO Dex Marker (shadow, event pokes, etc.)
- Donations


