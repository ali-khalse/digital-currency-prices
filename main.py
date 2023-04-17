from pydantic import BaseModel
from fastapi import FastAPI
from requests import get
import json,uvicorn
#-----------------------------------------
global text
text = json.loads(get("https://www.binance.com/api/v1/ticker/allPrices").text)
#-----------------------------------------
def check_valid(NAME:str):
    arrr = list(map(lambda x: x["symbol"], text))
    return (NAME in arrr)

def get_value(NAME:str):
    for i in text:
        if i["symbol"] == NAME:
            return i["price"]

#-----------------------------------------
app = FastAPI()
@app.get("/")
def read_root():
    return list(map(lambda x: x["symbol"], text))

@app.get("/{item_id}")
def read_item(item_id:str ):
    id_ = item_id.upper()
    if check_valid(id_):
        return {"symbol": id_,"price":get_value(id_)}
    else:
        return {"Error": "404"}
#-----------------------------------------
if __name__ == "__main__":
    uvicorn.run(app, host="127.0.0.1", port=8000)
