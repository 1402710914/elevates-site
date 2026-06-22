/**
 * ELEVATES — form data ko Google Sheet me row ke roop me bhejta hai.
 *
 * Pehli baar: Run → testOpenSpreadsheet → permissions Allow karo.
 * Phir: Deploy → New deployment → Web app → Execute as: Me, Who has access: Anyone
 *
 * SPREADSHEET_ID = tumhari sheet ke URL ka beech wala lamba code.
 */

var SPREADSHEET_ID = '1ACYbH3BcjHTzX-Ih_kBsDNuXwUMT022nWzbZIdfHBHA';

/** Yahi exact string PHP me GOOGLE_SHEET_SECRET honi chahiye */
var WEBAPP_SECRET = 'Elevates2026Secret_Apr19_New';

/** Headers for each sheet tab */
var SHEET_HEADERS = {
  'Enquiries': ['Submitted At', 'Source', 'First Name', 'Last Name', 'Email', 'Phone', 'Company', 'Subject', 'Message'],
  'Job_Placement': ['Submitted At', 'Name', 'Phone', 'Email', 'Total Experience (Years)', 'Qualification', 'Current Organization', 'Designation & Expertise', 'Current CTC', 'Expected CTC'],
  'Hiring_Assistance': ['Submitted At', 'Name', 'Phone', 'Email', 'Organization', 'Resources & Salary'],
  'AI_Assessment': ['Submitted At', 'Name', 'Phone', 'Email', 'Designation', 'Current Company', 'Experience (Years)', 'Interested Role']
};

/** Pehli baar permission ke liye: dropdown se chuno → Run dabao */
function testOpenSpreadsheet() {
  var ss = SpreadsheetApp.openById(SPREADSHEET_ID);
  Logger.log('OK: ' + ss.getName());
}

/** Browser test: .../exec?ping=1&secret=YOUR_SECRET */
function doGet(e) {
  var p = e && e.parameter ? e.parameter : {};
  if (p.ping === '1' && p.secret === WEBAPP_SECRET) {
    return jsonOut({ ok: true, message: 'web app is live' });
  }
  return jsonOut({ ok: false, hint: 'use ?ping=1&secret=YOUR_SECRET or POST JSON from server' });
}

function doPost(e) {
  try {
    if (!e || !e.postData) {
      return jsonOut({ ok: false, error: 'no postData' });
    }

    var raw = e.postData.contents || '';
    if (!raw) {
      return jsonOut({ ok: false, error: 'no body' });
    }

    var data = JSON.parse(raw);
    if (data.secret !== WEBAPP_SECRET) {
      return jsonOut({ ok: false, error: 'unauthorized' });
    }

    var sheetName = data.sheet;
    var row = data.row;

    if (!sheetName || !row || !Array.isArray(row)) {
      return jsonOut({ ok: false, error: 'bad payload' });
    }

    // Open spreadsheet
    var ss = SpreadsheetApp.openById(SPREADSHEET_ID);
    var sh = ss.getSheetByName(sheetName);

    // Create sheet if it doesn't exist
    if (!sh) {
      sh = ss.insertSheet(sheetName);
    }

    // Add headers if sheet is empty
    if (sh.getLastRow() === 0) {
      var headers = SHEET_HEADERS[sheetName];
      if (headers) {
        sh.appendRow(headers);
      }
    }

    // Append the data row
    sh.appendRow(row);

    return jsonOut({ ok: true });

  } catch (err) {
    return jsonOut({ ok: false, error: String(err) });
  }
}

function jsonOut(obj) {
  return ContentService
    .createTextOutput(JSON.stringify(obj))
    .setMimeType(ContentService.MimeType.JSON);
}
