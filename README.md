# Google Sheets API integration

## Running the project
- run `composer install`
- run `cp .env.example .env`
- update `GOOGLE_SPREADSHEET_SERVICE` and `GOOGLE_SPREADSHEET_ID` in the `.env` file
- run `php artisan key:generate`
- run `php artisan lv:coupon`
- check the linked [Google Spreadsheet](https://docs.google.com/spreadsheets/d/1SzsBJRAbDsJPLnihUCO8MpQ17ZHdxTxwVQVI1SDmHUs/edit#gid=282692849)
- make sure the coupon codes went to the correct sheet (Sheet1: MD-xxxxx, Sheet2: CNY-xxxxx)
