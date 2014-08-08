now = new Date();
conn = new Mongo();
db = conn.getDB("quantum");
result1 = db.users.insert({
    _id: "console",
    aclRole: "system",
    fullName: "Superuser Console",
    emailAddress: "console",
    created: now,
    updated: now
});
print(result1);
result2 = db.users.insert({
    _id: "system",
    aclRole: "system",
    fullName: "The Robot",
    emailAddress: "system",
    created: now,
    updated: now
});
print(result2);