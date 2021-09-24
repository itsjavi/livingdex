# Dumps Pokemon GO data to JSON arrays of objects.
# First element is always null (to be able to print JSON line by line).
# Usage: python3 pogo-dumper/dumper.py <moves|pokemon>

import sys, json

from pogodata import PogoData

def main(argv):
   if len(argv) < 1 :
      print('[]')
      sys.exit()
   if argv[0] == "moves":
      data = PogoData(language="english")
      print("[\nnull")
      for entry in data.moves:
        print("," + json.dumps(entry.raw))
      print("\n]\n")
   elif argv[0] in ("species", "pokemon"):
      data = PogoData(language="english")
      print("[\nnull")
      for entry in data.mons:
        print("," + json.dumps(entry.raw))
      print("\n]\n")
   else:
      print('[]')
      sys.exit()
   sys.exit()

if __name__ == "__main__":
   main(sys.argv[1:])
