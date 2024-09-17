<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Total Revenue</th>
                        <th>Products Sold</th>
                        <th>Avg. Order Value (With Promotion)</th>
                        <th>Avg. Order Value (Without Promotion)</th>
                    </tr>
                </thead>
                <tbody>
                    <xsl:for-each select="promotionPerformanceReport/promotion">
                        <tr>
                            <td><xsl:value-of select="id"/></td>
                            <td><xsl:value-of select="title"/></td>
                            <td><xsl:value-of select="totalRevenue"/></td>
                            <td><xsl:value-of select="productsSold"/></td>
                            <td><xsl:value-of select="averageOrderValueWithPromotion"/></td>
                            <td><xsl:value-of select="averageOrderValueWithoutPromotion"/></td>
                        </tr>
                    </xsl:for-each>
                </tbody>
            </table>
    </xsl:template>
</xsl:stylesheet>