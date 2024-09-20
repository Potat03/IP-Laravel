<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes"/>

    <xsl:template match="/">
        <html>
        <head>
            <title>Customer Report</title>
        </head>
        <body>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Tier</th>
                    <th>Status</th>
                    <th>Total Spent</th>
                </tr>
                <xsl:for-each select="//customer">
                    <tr>
                        <td><xsl:value-of select="id"/></td>
                        <td><xsl:value-of select="username"/></td>
                        <td><xsl:value-of select="email"/></td>
                        <td><xsl:value-of select="tier"/></td>
                        <td><xsl:value-of select="status"/></td>
                        <td><xsl:value-of select="total_spent"/></td>
                    </tr>
                </xsl:for-each>
            </table>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
