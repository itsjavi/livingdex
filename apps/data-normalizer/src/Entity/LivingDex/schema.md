# Schema

## Tables

### pokemon

- id
- gen
- dex_num
- unique_id (1-0001-001-mM)
- slug
- form_slug
- name
- form_name
- home_sprite
- mini_sprite
- base_species_id
- is_base_species
- is_in_home
- is_cosmetic
- is_female_form
- is_male_form
- is_fusion
- is_mega
- is_primal
- is_regional
- is_totem
- is_gmax
- can_dynamax
- showdown_name
- veekun_name
- sorting_order (in the general list)

### pokemon_form

- id
- gen
- pokemon_id
- base_pokemon_id
- is_reversible
- is_volatile (or loses form after depositing in box or transferring, or hoopa)
- in_battle_only
- required_item_id
- required_move_id
- required_weather
- fusion_pokemon_id
- sorting_order (in the list of forms if the base pokemon)

### pokemon_data

- id
- gen
- pokemon_id
- type1
- type2
- egg_group1
- egg_group2
- ability1_id
- ability2_id
- ability_hidden_id
- height
- weight
- color
- shape
- male_ratio
- female_ratio
- leveling_rate
- catch_rate
- hatch_cycles
- base_friendship
- base_hp
- base_attack
- base_defense
- base_sp_attack
- base_sp_defense
- base_speed
- yield_base_exp
- yield_hp
- yield_attack
- yield_defense
- yield_sp_attack
- yield_sp_defense
- yield_speed

### pokemon_move

- id
- gen
- pokemon_id
- move_id
- learn_method
- learn_level
- sorting_order ?
- is_signature_move
- z_crystal_item_id

### pokemon_evolution

- id
- gen
- pokemon_id
- from_pokemon_id
- evo_method
- evo_level
- evo_item_id
- evo_move_id
- evo_condition

### ability

- id
- gen
- slug
- name
- rating
- showdown_name
- veekun_name

### move

- id
- gen
- slug
- name
- type
- category
- power
- accuracy
- pp
- priority
- is_zmove
- showdown_name
- veekun_name

### item

- id
- gen
- slug
- name
- pocket / category
- showdown_name
- veekun_name

Item categories:

- medicine
- pokeball
- battle_item
- berry
- power_up
- machine
- held_item
- z_crystal
- mega_stone
- treasure
- key_item
- ingredient
- other

### location

- id
- gen
- slug
- name
- region
- veekun_name

### pokemon_location

- id
- gen
- game_group_id
- game_id
- location_id
- encounter_type

### game

- id
- gen
- slug
- name
- game_group_id

### game_group

- id
- gen
- slug
- name

## Use Cases

### Get All Species

```sql
SELECT *
FROM pokemon
WHERE is_species_base = 1
ORDER BY num
```

### Get All Pokemon with gender differences

```sql
SELECT *
FROM pokemon
WHERE (is_male_form = 1 AND is_female_form = 0)
   OR (is_male_form = 0 AND is_female_form = 1)
ORDER BY num
```

### Get All Forms of a single Species

```sql
SELECT *
FROM pokemon_form
WHERE base_pokemon = 150
ORDER BY sorting_order
```

### Linking Necrozma Forms

In `pokemon`:

- necrozma
- necrozma-dusk-mane
- necrozma-dawn-wings
- necrozma-ultra

In `pokemon_form` (base_pokemon, pokemon):

- necrozma <--> necrozma-dusk-mane
- necrozma <--> necrozma-dawn-wings
- necrozma-dusk-mane <--> necrozma-ultra
- necrozma-dawn-wings <--> necrozma-ultra

In a similar way, we can link Zygarde forms.

This was not possible with the `base_form` column approach in the `pokemon` table, because necrozma-ultra can have 2
base forms, like zygarde-complete.

### Get all stats and moves from lycanroc-dusk in gen 7

```sql
SELECT *
FROM pokemon
WHERE slug = 'lycanroc-dusk'
LIMIT 1
```

```sql
SELECT *
FROM pokemon_data
WHERE pokemon_id = 104343
  AND gen = 7
LIMIT 1
```

```php
 $pokemon->getData(gen: 7); // 
```

https://tocacar.com/filtering-doctrine-associations-with-criteria-ad38453dec85

```sql
SELECT *
FROM pokemon_moves
WHERE pokemon_id = 104343
  AND gen = 7
LIMIT 1
```

```php
 $pokemon->getMoves(gen: 7); // 
```
