from datetime import timezone, datetime
from dateutil import tz

tzFrom = tz.gettz('GMT')
tzTo   = tz.gettz('Europe/Berlin')
dt     = datetime.fromisoformat('2025-07-18T00:00')

print(dt)
print(dt.astimezone(tzTo).isoformat())

dt.replace(tzinfo=tzFrom)
dt = dt.astimezone(tzTo)

dtLocal = datetime.fromisoformat(dt.strftime('%Y-%m-%d %H:%M:%S%z'))
# print(dtLocal.astimezone(tzTo).timestamp())
